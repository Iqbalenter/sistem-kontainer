<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Services\ContainerPlacementService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;

class DeliveryController extends Controller
{
    protected $containerPlacementService;

    public function __construct(ContainerPlacementService $containerPlacementService)
    {
        $this->containerPlacementService = $containerPlacementService;
    }

    public function index()
    {
        $deliveries = Delivery::with('user')->latest()->get();
        return view('admin.delivery', compact('deliveries'));
    }

    public function printPDF(Request $request)
    {
        $query = Delivery::with('user', 'block');

        // Filter berdasarkan bulan jika dipilih
        if ($request->has('month') && $request->month) {
            $year = $request->get('year', date('Y'));
            $query->whereMonth('created_at', $request->month)
                  ->whereYear('created_at', $year);
        }

        $deliveries = $query->latest()->get();
        
        // Validasi jika tidak ada data
        if ($deliveries->isEmpty()) {
            $filterText = '';
            if ($request->has('month') && $request->month) {
                $monthName = DateTime::createFromFormat('!m', $request->month)->format('F');
                $year = $request->get('year', date('Y'));
                $filterText = "bulan {$monthName} {$year}";
            } else {
                $filterText = 'periode yang dipilih';
            }
            
            return redirect()->back()->with('error', "Tidak ada data delivery pada {$filterText}.");
        }
        
        $filterText = '';
        if ($request->has('month') && $request->month) {
            $monthName = DateTime::createFromFormat('!m', $request->month)->format('F');
            $year = $request->get('year', date('Y'));
            $filterText = "Bulan: {$monthName} {$year}";
        } else {
            $filterText = 'Semua Data';
        }

        $pdf = Pdf::loadView('admin.pdf.delivery', compact('deliveries', 'filterText'));
        
        return $pdf->download('laporan-delivery-' . date('Y-m-d') . '.pdf');
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Received delivery request:', $request->all());
            
            $validatedData = $request->validate([
                'container_number' => 'required|string',
                'license_plate' => 'required|string',
                'luggage' => 'required|string',
                'liquid_status' => 'required|in:cair,non-cair'
            ]);

            \Log::info('Validated delivery data:', $validatedData);

            // Tambahkan user_id dari user yang sedang login
            $validatedData['user_id'] = auth()->id();
            $validatedData['status'] = 'pending';

            \Log::info('Creating delivery with data:', $validatedData);

            $delivery = Delivery::create($validatedData);

            \Log::info('Delivery created successfully:', ['delivery_id' => $delivery->id]);

            return redirect()->route('delivery.waiting', ['delivery' => $delivery->id]);
        } catch (\Exception $e) {
            \Log::error('Error creating delivery:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat permintaan: ' . $e->getMessage());
        }
    }

    public function confirm(Delivery $delivery)
    {
        try {
            \Log::info('Starting confirmation process for delivery: ' . $delivery->id);
            
            $block = $this->containerPlacementService->assignBlock($delivery);
            
            \Log::info('Block assigned: ' . $block->name);
            
            // Update delivery dengan block_id
            $delivery->update([
                'status' => 'confirmed',
                'block_id' => $block->id
            ]);

            // Refresh model untuk mendapatkan relasi yang baru
            $delivery = $delivery->fresh(['block']);

            \Log::info('Delivery updated with block:', [
                'delivery_id' => $delivery->id,
                'block_id' => $delivery->block_id,
                'block_name' => $delivery->block ? $delivery->block->name : 'Not assigned'
            ]);

            return response()->json([
                'message' => "Delivery dikonfirmasi dan ditempatkan di Block {$block->name}",
                'delivery' => $delivery,
                'status' => 'confirmed',
                'block' => $block->name
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in confirmation process: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function reject(Request $request, Delivery $delivery)
    {
        $request->validate([
            'notes' => 'required|string'
        ]);

        try {
            $delivery->update([
                'status' => 'rejected',
                'notes' => $request->notes
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Delivery berhasil ditolak!',
                'delivery' => $delivery
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showReject(Delivery $delivery)
    {
        if ($delivery->status !== 'rejected') {
            return redirect()->route('index')->with('error', 'Delivery ini tidak dalam status ditolak');
        }

        try {
            return view('user.delivery_reject', compact('delivery'));
        } catch (\Exception $e) {
            \Log::error('Error showing delivery reject page: ' . $e->getMessage());
            return redirect()->route('index')
                ->with('error', 'Terjadi kesalahan saat menampilkan halaman reject: ' . $e->getMessage());
        }
    }

    public function checkStatus(Delivery $delivery)
    {
        try {
            $block = optional($delivery->block)->name;
            $data = [
                'status' => $delivery->status,
                'block' => $block,
                'delivery_id' => $delivery->id,
                'redirect_url' => $delivery->status === 'confirmed' 
                    ? route('delivery.ticket', ['delivery' => $delivery->id])
                    : ($delivery->status === 'rejected' 
                        ? route('delivery.reject', ['delivery' => $delivery->id]) 
                        : null)
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengecek status',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function showTicket(Delivery $delivery)
    {
        // Pastikan user yang mengakses adalah pemilik delivery atau admin
        if (auth()->user()->role !== 'admin' && $delivery->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($delivery->status !== 'confirmed') {
            return redirect()->back()->with('error', 'Ticket hanya tersedia untuk delivery yang sudah dikonfirmasi');
        }

        // Load relasi block jika belum di-load
        if (!$delivery->relationLoaded('block')) {
            $delivery->load('block');
        }

        // Log untuk debugging
        \Log::info('Delivery data for ticket:', [
            'delivery_id' => $delivery->id,
            'block_id' => $delivery->block_id,
            'block' => $delivery->block
        ]);

        $data = [
            'container_number' => $delivery->container_number,
            'created_at' => Carbon::parse($delivery->created_at)->format('M d, Y'),
            'license_plate' => $delivery->license_plate,
            'luggage' => $delivery->luggage,
            'liquid_status' => $delivery->liquid_status,
            'block' => $delivery->block ? $delivery->block->name : 'Not assigned'
        ];

        return view('user.ticket', $data);
    }
}
