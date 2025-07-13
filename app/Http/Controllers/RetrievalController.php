<?php

namespace App\Http\Controllers;

use App\Http\Requests\RetrievalRequest;
use App\Models\Retrieval;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;

class RetrievalController extends Controller
{
    public function store(RetrievalRequest $request)
    {
        try {
            $retrieval = Retrieval::create($request->validated());
            
            // Simpan data retrieval ke session
            session(['retrieval_data' => [
                'id' => $retrieval->id,
                'container_number' => $retrieval->container_number,
                'container_name' => $retrieval->container_name,
                'license_plate' => $retrieval->license_plate,
                'created_at' => $retrieval->created_at->format('d/m/Y H:i')
            ]]);

            // Redirect ke halaman waiting
            return view('user.retrieval_waiting', [
                'container_number' => $retrieval->container_number,
                'container_name' => $retrieval->container_name,
                'license_plate' => $retrieval->license_plate,
                'created_at' => $retrieval->created_at->format('d/m/Y H:i')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat permintaan pengambilan: ' . $e->getMessage());
        }
    }

    public function adminIndex()
    {
        $retrievals = Retrieval::latest()->paginate(10);
        return view('admin.retrieval', compact('retrievals'));
    }

    public function printPDF(Request $request)
    {
        $query = Retrieval::query();

        // Filter berdasarkan bulan jika dipilih
        if ($request->has('month') && $request->month) {
            $year = $request->get('year', date('Y'));
            $query->whereMonth('created_at', $request->month)
                  ->whereYear('created_at', $year);
        }

        $retrievals = $query->latest()->get();
        
        // Validasi jika tidak ada data
        if ($retrievals->isEmpty()) {
            $filterText = '';
            if ($request->has('month') && $request->month) {
                $monthName = DateTime::createFromFormat('!m', $request->month)->format('F');
                $year = $request->get('year', date('Y'));
                $filterText = "bulan {$monthName} {$year}";
            } else {
                $filterText = 'periode yang dipilih';
            }
            
            return redirect()->back()->with('error', "Tidak ada data retrieval pada {$filterText}.");
        }
        
        $filterText = '';
        if ($request->has('month') && $request->month) {
            $monthName = DateTime::createFromFormat('!m', $request->month)->format('F');
            $year = $request->get('year', date('Y'));
            $filterText = "Bulan: {$monthName} {$year}";
        } else {
            $filterText = 'Semua Data';
        }

        $pdf = Pdf::loadView('admin.pdf.retrieval', compact('retrievals', 'filterText'));
        
        return $pdf->download('laporan-retrieval-' . date('Y-m-d') . '.pdf');
    }

    public function index()
    {
        $retrievals = Retrieval::latest()->paginate(10);
        return view('retrievals.index', compact('retrievals'));
    }

    public function updateStatus(Request $request, Retrieval $retrieval)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Jika status yang diminta adalah 'approved', periksa keberadaan container
            if ($request->status === 'approved') {
                // Cari container di tabel deliveries
                $delivery = Delivery::where('container_number', $retrieval->container_number)
                    ->where('status', 'confirmed')
                    ->whereNotNull('block_id')
                    ->first();

                if (!$delivery) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Container tidak ditemukan di block manapun atau belum dikonfirmasi. Permintaan pengambilan tidak dapat disetujui.'
                    ], 422);
                }

                // Simpan informasi block sebelum dilepaskan
                $blockName = $delivery->block->name;

                // Update status delivery menjadi retrieved
                $delivery->update([
                    'status' => 'retrieved'
                ]);

                // Lepaskan container dari block
                $block = $delivery->block;
                $block->current_capacity = max(0, $block->current_capacity - 1);
                
                // Reset tipe block jika kosong
                if ($block->current_capacity === 0) {
                    $block->current_type = null;
                }
                
                $block->is_full = false;
                $block->save();

                // Lepaskan block_id dari delivery
                $delivery->block_id = null;
                $delivery->save();

                // Simpan block_name di notes retrieval untuk referensi
                $notes = $request->notes ? $request->notes . "\n" : "";
                $notes .= "Block: " . $blockName;
                $request->merge(['notes' => $notes]);
            }

            $retrieval->update([
                'status' => $request->status,
                'notes' => $request->notes
            ]);

            DB::commit();

            $statusMessage = $request->status === 'approved' 
                ? 'Permintaan pengambilan container berhasil disetujui!'
                : 'Permintaan pengambilan container ditolak!';

            return response()->json([
                'success' => true,
                'message' => $statusMessage,
                'retrieval' => $retrieval->fresh()
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error in retrieval approval: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkStatus(Retrieval $retrieval)
    {
        return response()->json([
            'status' => $retrieval->status,
            'message' => $retrieval->notes
        ]);
    }

    public function showTicket(Retrieval $retrieval)
    {
        if ($retrieval->status !== 'approved') {
            return redirect()->route('index')->with('error', 'Permintaan pengambilan belum disetujui');
        }

        try {
            // Ekstrak nama block dari notes
            $blockName = null;
            if ($retrieval->notes) {
                if (preg_match('/Block: ([A-E])/', $retrieval->notes, $matches)) {
                    $blockName = $matches[1];
                }
            }

            if (!$blockName) {
                return redirect()->route('index')
                    ->with('error', 'Data lokasi container tidak ditemukan');
            }

            return view('user.retrieval_ticket', [
                'container_number' => $retrieval->container_number,
                'container_name' => $retrieval->container_name,
                'license_plate' => $retrieval->license_plate,
                'created_at' => $retrieval->created_at->format('d/m/Y H:i'),
                'block' => $blockName
            ]);
        } catch (\Exception $e) {
            \Log::error('Error showing retrieval ticket: ' . $e->getMessage());
            return redirect()->route('index')
                ->with('error', 'Terjadi kesalahan saat menampilkan ticket: ' . $e->getMessage());
        }
    }

    public function showReject(Retrieval $retrieval)
    {
        if ($retrieval->status !== 'rejected') {
            return redirect()->route('index')->with('error', 'Permintaan pengambilan ini tidak dalam status ditolak');
        }

        try {
            return view('user.reject', compact('retrieval'));
        } catch (\Exception $e) {
            \Log::error('Error showing reject page: ' . $e->getMessage());
            return redirect()->route('index')
                ->with('error', 'Terjadi kesalahan saat menampilkan halaman reject: ' . $e->getMessage());
        }
    }
}
