<?php

use Illuminate\Support\Facades\Route;

Route::get('/admin/orders', [AdminController::class, 'orders'])->middleware('auth');

