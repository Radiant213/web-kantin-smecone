<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KantinController;
use App\Http\Controllers\KioskController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KantinController as AdminKantinController;
use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(['middleware' => ['web', 'auth']]);
use App\Http\Controllers\Admin\KioskController as AdminKioskController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\KioskApplicationController;
use App\Http\Controllers\Penjual\KioskController as PenjualKioskController;
use App\Http\Controllers\Penjual\MenuController as PenjualMenuController;
use App\Http\Controllers\Penjual\OrderController as PenjualOrderController;
use Illuminate\Support\Facades\Route;

// ── Public Routes ──
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kantin/{kantin}', [KantinController::class, 'show'])->name('kantin.show');
Route::get('/kiosk/{kiosk}', [KioskController::class, 'show'])->name('kiosk.show');

// ── Authenticated (Pembeli) Routes ──
Route::middleware(['auth'])->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{menuId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── Authenticated (Penjual) Routes ──
Route::middleware(['auth', 'role:penjual'])->prefix('penjual')->name('penjual.')->group(function () {
    Route::post('/kiosk/apply', [PenjualKioskController::class, 'apply'])->name('kiosk.apply');
    Route::put('/kiosk/update-details', [PenjualKioskController::class, 'updateDetails'])->name('kiosk.updateDetails');
    Route::resource('menus', PenjualMenuController::class)->except(['index', 'show']);
    Route::get('/orders', [PenjualOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/status', [PenjualOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

// ── Admin Routes ──
use App\Http\Controllers\Admin\SearchController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::resource('kantins', AdminKantinController::class)->except(['show']);
    Route::resource('kiosks', AdminKioskController::class)->except(['show']);
    Route::resource('users', AdminUserController::class)->except(['show']);
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');

    // Kiosk Applications
    Route::get('/kiosk-applications', [KioskApplicationController::class, 'index'])->name('kiosk-applications.index');
    Route::post('/kiosk-applications/{application}/approve', [KioskApplicationController::class, 'approve'])->name('kiosk-applications.approve');
    Route::post('/kiosk-applications/{application}/reject', [KioskApplicationController::class, 'reject'])->name('kiosk-applications.reject');
});

// Web Push Subscriptions
Route::post('/push-subscriptions', [\App\Http\Controllers\PushSubscriptionController::class, 'store'])->middleware('auth');
Route::delete('/push-subscriptions', [\App\Http\Controllers\PushSubscriptionController::class, 'destroy'])->middleware('auth');

require __DIR__ . '/auth.php';
