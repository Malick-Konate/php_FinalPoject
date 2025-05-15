<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function orders()
    {
        $orders = Order::with('items')->get();
        return view('admin.orders', compact('orders'));
    }
}

