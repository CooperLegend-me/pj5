<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ChatController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/reviews', [PageController::class, 'reviews'])->name('reviews');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/calculator', [PageController::class, 'calculator'])->name('calculator');

Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Маршруты для сообщений
    Route::get('/orders/{order}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/orders/{order}/messages', [ChatController::class, 'sendMessage'])->name('chat.send');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('/orders/{order}/messages', [AdminOrderController::class, 'getMessages'])->name('orders.messages');
    Route::post('/orders/{order}/messages', [AdminOrderController::class, 'sendMessage'])->name('orders.send-message');
});

Route::get('/api/check-auth', function () {
    return response()->json([
        'authenticated' => auth()->check()
    ]);
});

require __DIR__.'/auth.php'; 