<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/checkout', [OrderController::class, 'checkoutForm']);
Route::post('/checkout', [OrderController::class, 'placeOrder']);