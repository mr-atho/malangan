<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Frontend
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/halaman/{slug}', [PageController::class, 'show'])->name('pages.show');
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('products.show');

// Cart
Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
Route::patch('/keranjang/{item}', [CartController::class, 'update'])->name('cart.update');
Route::post('/keranjang/{item}/tambah', [CartController::class, 'increment'])->name('cart.increment');
Route::post('/keranjang/{item}/kurang', [CartController::class, 'decrement'])->name('cart.decrement');
Route::delete('/keranjang/{item}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/keranjang/count', [CartController::class, 'count'])->name('cart.count');

// Checkout & Orders (auth required)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{orderNumber}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', Admin\ProductController::class);
    Route::post('products/{product}/images', [Admin\ProductController::class, 'storeImages'])->name('products.images.store');
    Route::patch('products/{product}/images/{image}/primary', [Admin\ProductController::class, 'setPrimaryImage'])->name('products.images.primary');
    Route::delete('products/{product}/images/{image}', [Admin\ProductController::class, 'destroyImage'])->name('products.images.destroy');
    Route::resource('categories', Admin\CategoryController::class)->except(['show']);
    Route::get('orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('orders.status');
    Route::patch('orders/{order}/shipping', [Admin\OrderController::class, 'updateShipping'])->name('orders.shipping');

    Route::get('banners', [Admin\BannerController::class, 'index'])->name('banners.index');
    Route::post('banners', [Admin\BannerController::class, 'store'])->name('banners.store');
    Route::delete('banners/{banner}', [Admin\BannerController::class, 'destroy'])->name('banners.destroy');

    Route::resource('pages', Admin\PageController::class)->except(['show']);

    Route::get('stok', [Admin\StockController::class, 'index'])->name('stock.index');
    Route::patch('stok/{product}', [Admin\StockController::class, 'update'])->name('stock.update');

    Route::get('users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}', [Admin\UserController::class, 'show'])->name('users.show');
    Route::get('users/{user}/edit', [Admin\UserController::class, 'edit'])->name('users.edit');
    Route::patch('users/{user}', [Admin\UserController::class, 'update'])->name('users.update');
    Route::patch('users/{user}/toggle-role', [Admin\UserController::class, 'toggleRole'])->name('users.toggle-role');
    Route::delete('users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');

    Route::get('notifications', [Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('notifications/mark-all-read', [Admin\NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    Route::delete('notifications/destroy-all', [Admin\NotificationController::class, 'destroyAll'])->name('notifications.destroy-all');
    Route::delete('notifications/{id}', [Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');
});

require __DIR__.'/auth.php';
