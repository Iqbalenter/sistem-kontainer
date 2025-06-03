<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('causer')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.log_activity', compact('logs'));
    }
}
