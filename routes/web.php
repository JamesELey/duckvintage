<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Product Management
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'show' => 'admin.products.show',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy'
    ]);
    
    // Category Management
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'show' => 'admin.categories.show',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy'
    ]);
    
    // Order Management
    Route::get('orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.orders.update-status');
    
    // User Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy'
    ]);
    Route::patch('users/{user}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('admin.users.reset-password');
    
    // Blog Management
    Route::get('blog', [App\Http\Controllers\Admin\BlogController::class, 'index'])->name('admin.blog.index');
    Route::get('blog/create', [App\Http\Controllers\Admin\BlogController::class, 'create'])->name('admin.blog.create');
    Route::post('blog', [App\Http\Controllers\Admin\BlogController::class, 'store'])->name('admin.blog.store');
    Route::get('blog/{id}/edit', [App\Http\Controllers\Admin\BlogController::class, 'edit'])->name('admin.blog.edit');
    Route::patch('blog/{id}', [App\Http\Controllers\Admin\BlogController::class, 'update'])->name('admin.blog.update');
    Route::delete('blog/{id}', [App\Http\Controllers\Admin\BlogController::class, 'destroy'])->name('admin.blog.destroy');
});

// Customer Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');
    
    // GDPR Compliance
    Route::get('/profile/export-data', [App\Http\Controllers\ProfileController::class, 'exportData'])->name('profile.export-data');
    Route::delete('/profile/delete-account', [App\Http\Controllers\ProfileController::class, 'deleteAccount'])->name('profile.delete-account');
    
    // Shopping Cart
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    
    // Checkout & Payment
    Route::get('/checkout', [App\Http\Controllers\PaymentController::class, 'showCheckout'])->name('checkout');
    Route::post('/payment/process', [App\Http\Controllers\PaymentController::class, 'processPayment'])->name('payment.process');
    Route::get('/payment/success/{order}', [App\Http\Controllers\PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/cancel/{order}', [App\Http\Controllers\PaymentController::class, 'paymentCancel'])->name('payment.cancel');
    
    // Orders
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
});

// Public Routes
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::get('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');

// Blog Routes
Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blog}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// GDPR Policy Pages
Route::get('/privacy-policy', [App\Http\Controllers\PolicyController::class, 'privacy'])->name('privacy-policy');
Route::get('/terms-of-service', [App\Http\Controllers\PolicyController::class, 'terms'])->name('terms-of-service');
Route::get('/cookie-policy', [App\Http\Controllers\PolicyController::class, 'cookies'])->name('cookie-policy');
