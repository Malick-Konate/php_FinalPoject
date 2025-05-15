<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', ProductController::class)->middleware('auth');

Route::get('/cart/add/{id}', [CartController::class, 'addToCart']);
Route::view('/cart', 'cart');