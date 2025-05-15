<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

 function checkoutForm() {
    return view('checkout');
}

 function placeOrder(Request $request) {
    $validated = $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'address' => 'required',
        'payment_type' => 'required'
    ]);

    $cart = session('cart', []);
    $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

    $order = Order::create(array_merge($validated, ['total' => $total]));

    foreach ($cart as $id => $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $id,
            'quantity' => $item['quantity'],
            'price' => $item['price']
        ]);
    }

    session()->forget('cart');
    return redirect('/thank-you');
}