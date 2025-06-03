<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Retrieval;
use App\Models\Block;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Data kontainer yang masuk hari ini (delivery)
        $inboundToday = Delivery::whereDate('created_at', Carbon::today())
            ->where('status', 'confirmed')
            ->count();

        // Data kontainer yang keluar hari ini (retrieval)
        $outboundToday = Retrieval::whereDate('retrieval_date', Carbon::today())
            ->where('status', 'approved')
            ->count();

        // Data kontainer yang menunggu konfirmasi
        $awaitingConfirmation = Delivery::where('status', 'pending')->count();

        // Data kontainer per blok
        $blocks = Block::withCount('deliveries')->get();
        $containersPerBlock = [];
        foreach ($blocks as $block) {
            $containersPerBlock[$block->name] = $block->deliveries_count;
        }

        // Total users
        $totalUsers = User::count();

        return view('admin.dashboard', compact(
            'inboundToday',
            'outboundToday',
            'awaitingConfirmation',
            'containersPerBlock',
            'totalUsers'
        ));
    }
}
