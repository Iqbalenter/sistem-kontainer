<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\RetrievalController;
use App\Http\Controllers\ActivityLogController;
use App\Models\Delivery;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;

// Halaman Utama (Bebas Akses)
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.index');
        }
        return redirect()->route('index');
    }
    return view('index');
});

Route::middleware(['web'])->group(function () {
    // Authentication Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Routes untuk User yang sudah login
    Route::middleware(['auth'])->group(function () {
        // Routes untuk semua user yang sudah login
        Route::post('/delivery', [DeliveryController::class, 'store'])->name('delivery.store');
        Route::get('/delivery/{delivery}/check-status', [DeliveryController::class, 'checkStatus'])->name('delivery.check-status');
        Route::get('/user/ticket/{delivery}', [DeliveryController::class, 'showTicket'])->name('delivery.ticket');
        Route::get('/user/waiting/{delivery}', function($delivery) {
            $delivery = Delivery::findOrFail($delivery);
            return view('user.waiting', compact('delivery'));
        })->name('delivery.waiting');
        Route::get('/delivery/{delivery}/reject', [DeliveryController::class, 'showReject'])->name('delivery.reject');

        Route::post('/retrieval', [RetrievalController::class, 'store'])->name('retrieval.store');
        Route::get('/retrievals', [RetrievalController::class, 'index'])->name('retrievals.index');
        Route::patch('/retrievals/{retrieval}/status', [RetrievalController::class, 'updateStatus'])->name('retrievals.update-status');
        Route::get('/retrievals/{retrieval}/reject', [RetrievalController::class, 'showReject'])->name('retrieval.reject');

        // Retrieval routes
        Route::post('/retrievals', [RetrievalController::class, 'store'])->name('retrieval.store');
        Route::get('/retrievals/{retrieval}/check-status', [RetrievalController::class, 'checkStatus'])->name('retrieval.check-status');
        Route::get('/retrievals/{retrieval}/ticket', [RetrievalController::class, 'showTicket'])->name('retrieval.ticket');

        // Routes khusus role user
        Route::middleware(['role:user'])->group(function () {
            Route::get('/index', function () {
                return view('user.index');
            })->name('index');
        });

        // Routes khusus role admin
        Route::middleware(['role:admin'])->group(function () {
            Route::get('/admin', [DashboardController::class, 'index'])->name('admin.index');

            Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
            
            Route::get('/admin/delivery', [DeliveryController::class, 'index'])->name('admin.delivery');

            Route::get('/admin/retrieval', [RetrievalController::class, 'adminIndex'])->name('admin.retrieval');

            // Block management routes
            Route::get('/admin/block-a', [BlockController::class, 'showBlockA'])->name('admin.block-a');
            Route::get('/admin/block-b', [BlockController::class, 'showBlockB'])->name('admin.block-b');
            Route::get('/admin/block-c', [BlockController::class, 'showBlockC'])->name('admin.block-c');
            Route::get('/admin/block-d', [BlockController::class, 'showBlockD'])->name('admin.block-d');
            Route::get('/admin/block-e', [BlockController::class, 'showBlockE'])->name('admin.block-e');
            Route::delete('/admin/blocks/{blockName}/containers/{delivery}', [BlockController::class, 'removeContainer'])->name('admin.blocks.removeContainer');

            // User Management Routes
            Route::get('/admin/user', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.user');
            Route::get('/admin/user/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.user.create');
            Route::post('/admin/user', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.user.store');
            Route::get('/admin/user/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit']);
            Route::put('/admin/user/{id}', [App\Http\Controllers\Admin\UserController::class, 'update']);
            Route::delete('/admin/user/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy']);

            // Activity Log Routes
            Route::get('/admin/log-activity', [ActivityLogController::class, 'index'])->name('admin.log_activity');

            // Print PDF Routes
            Route::get('/admin/delivery/print', [DeliveryController::class, 'printPDF'])->name('admin.delivery.print');
            Route::get('/admin/retrieval/print', [RetrievalController::class, 'printPDF'])->name('admin.retrieval.print');

            // Tambahkan route untuk confirm dan reject
            Route::post('/delivery/{delivery}/confirm', [DeliveryController::class, 'confirm'])->name('delivery.confirm');
            Route::post('/delivery/{delivery}/reject', [DeliveryController::class, 'reject'])->name('delivery.reject');
        });
    });
});

Route::middleware(['auth', 'admin'])->group(function () {
    
});



