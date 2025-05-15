<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/admin/orders', [AdminController::class, 'orders'])->middleware('auth');


Route::get('/checkout', [OrderController::class, 'checkoutForm']);
Route::post('/checkout', [OrderController::class, 'placeOrder']);