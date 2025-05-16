<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User; // Needed if you implement admin check

class AdminController extends Controller
{
     // You might add a constructor here to apply admin middleware
     // public function __construct()
     // {
     //     $this->middleware('admin'); // Assuming you create an 'admin' middleware
     // }

    /**
     * Display a listing of all orders for admins.
     */
    public function index()
    {
        // Fetch all orders, ordered by creation date (latest first)
        $orders = Order::with('user', 'items')->latest()->get(); // Eager load user and items

        // You could add pagination here later (Bonus Feature - Source 13)
        // $orders = Order::with('user', 'items')->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order details for admins.
     */
    public function show(Order $order)
    {
        // Route Model Binding fetches the order.
        // Eager load user and items if not already loaded
        $order->load('user', 'items');

        return view('admin.orders.show', compact('order'));
    }
}