<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Buyer\BuyerDashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Staff\StaffDashboardController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/signup', [RegisterController::class, 'showBuyerRegisterForm'])->name('register');
Route::post('/signup', [RegisterController::class, 'registerBuyer']);

Route::get('/seller/register', [RegisterController::class, 'showSellerRegisterForm'])->name('seller.register');
Route::post('/seller/register', [RegisterController::class, 'registerSeller']);

// Admin Routes (Role: admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/sellers', [AdminDashboardController::class, 'sellers'])->name('admin.sellers');
    Route::post('/sellers/generate', [AdminDashboardController::class, 'generateSellerAccount'])->name('admin.sellers.generate');
    Route::post('/sellers/{id}/status', [AdminDashboardController::class, 'updateSellerStatus'])->name('admin.sellers.status');
    Route::get('/buyers', [AdminDashboardController::class, 'buyers'])->name('admin.buyers');
    Route::get('/events', [AdminDashboardController::class, 'events'])->name('admin.events');
    Route::get('/transactions', [AdminDashboardController::class, 'transactions'])->name('admin.transactions');
    Route::get('/logs', [AdminDashboardController::class, 'logs'])->name('admin.logs');
    Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('admin.reports');
    Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('admin.settings');
});

// Seller Routes (Role: penjual)
Route::middleware(['auth', 'role:penjual'])->prefix('seller')->group(function () {
    Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('seller.dashboard');
    Route::get('/events', [SellerDashboardController::class, 'events'])->name('seller.events');
    Route::get('/events/create', [SellerDashboardController::class, 'createEventForm'])->name('seller.events.create');
    Route::post('/events', [SellerDashboardController::class, 'storeEvent'])->name('seller.events.store');
    Route::post('/events/{id}/extend', [SellerDashboardController::class, 'extendEvent'])->name('seller.events.extend');
    Route::get('/subscription', [SellerDashboardController::class, 'subscription'])->name('seller.subscription');
    Route::post('/subscription/purchase', [SellerDashboardController::class, 'purchaseSubscription'])->name('seller.subscription.purchase');
    Route::get('/staff', [SellerDashboardController::class, 'staff'])->name('seller.staff');
    Route::post('/staff/create', [SellerDashboardController::class, 'createStaffAccount'])->name('seller.staff.create');
    Route::get('/orders', [SellerDashboardController::class, 'orders'])->name('seller.orders');
    Route::get('/profile', [SellerDashboardController::class, 'profile'])->name('seller.profile');
    Route::get('/settings', [SellerDashboardController::class, 'settings'])->name('seller.settings');
});

// Staff Routes (Role: staf)
Route::middleware(['auth', 'role:staf'])->prefix('staff')->group(function () {
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('staff.dashboard');
    Route::post('/scan/validate', [StaffDashboardController::class, 'validateTicket'])->name('staff.scan.validate');
});

// Buyer Routes (Role: pembeli)
Route::middleware(['auth', 'role:pembeli'])->group(function () {
    Route::get('/dashboard', [BuyerDashboardController::class, 'index'])->name('buyer.dashboard');
    Route::get('/tickets', [BuyerDashboardController::class, 'tickets'])->name('buyer.tickets');
    Route::get('/tickets/{slug}', [BuyerDashboardController::class, 'showEvent'])->name('buyer.tickets.show');
    Route::post('/checkout', [BuyerDashboardController::class, 'checkout'])->name('buyer.checkout');
    Route::get('/orders', [BuyerDashboardController::class, 'orders'])->name('buyer.orders');
    Route::get('/orders/{id}', [BuyerDashboardController::class, 'showOrder'])->name('buyer.orders.show');
    Route::post('/orders/{id}/simulate-payment', [BuyerDashboardController::class, 'simulatePaymentSuccess'])->name('buyer.orders.simulate_payment');
    Route::get('/my-tickets', [BuyerDashboardController::class, 'myTickets'])->name('buyer.my_tickets');
    Route::get('/wishlist', [BuyerDashboardController::class, 'wishlist'])->name('buyer.wishlist');
    Route::post('/wishlist/toggle', [BuyerDashboardController::class, 'toggleWishlist'])->name('buyer.wishlist.toggle');
    Route::get('/loyalty', [BuyerDashboardController::class, 'loyalty'])->name('buyer.loyalty');
    Route::get('/profile', [BuyerDashboardController::class, 'profile'])->name('buyer.profile');
});
