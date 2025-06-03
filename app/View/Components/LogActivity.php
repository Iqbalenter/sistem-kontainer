<?php

namespace App\View\Components;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LogActivity extends Component
{
    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        $logs = ActivityLog::with(['causer'])
            ->latest()
            ->paginate(10);

        return view('components.log-activity', compact('logs'));
    }
} 