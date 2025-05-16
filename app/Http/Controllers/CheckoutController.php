<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth; 

class CheckoutController extends Controller
{

    public function index()
    {
        $cart = session()->get('cart', []);

        if (count($cart) === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout.index', compact('cart', 'total'));
    }


    public function placeOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_address' => 'required|string',
            'payment_method' => 'required|string|max:255',
        ]);

        $cart = session()->get('cart', []);

        if (count($cart) === 0) {
             return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => Auth::id(), 
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_address' => $request->customer_address,
                'payment_method' => $request->payment_method,
                'total_amount' => $total,
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                ]);

                $product = Product::find($item['id']);
                if ($product) {
                    $product->stock_quantity -= $item['quantity'];
                    if ($product->stock_quantity < 0) {
                   
                         $product->stock_quantity = 0;
                    }
                    $product->save();
                }
            }

            DB::commit(); 

            session()->forget('cart');

            return redirect()->route('order.success', $order->id)->with('success', 'Your order has been placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack(); 
            return redirect()->route('cart.index')->with('error', 'There was an error placing your order. Please try again.');
        }
    }

  
     public function orderSuccess(Order $order)
     {
         return view('checkout.success', compact('order'));
     }
}