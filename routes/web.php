<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('products', ProductController::class); 
});

Route::get('/products', [App\Http\Controllers\ProductController::class, 'catalog'])->name('catalog.index');

Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class); 
});

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');


Route::middleware('auth')->group(function () {
});

Route::middleware('auth')->group(function () {
    // ... existing authenticated routes (profile, product management) ...

    // Admin Order Management Routes
    Route::get('/admin/orders', [AdminController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [AdminController::class, 'show'])->name('admin.orders.show');

});

Route::post('/cart/add/{product}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::patch('/cart/update/{product}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{product}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
require __DIR__.'/auth.php';