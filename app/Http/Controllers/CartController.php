<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
  
    public function index()
    {
        $cart = session()->get('cart', []); 

  

        return view('cart.index', compact('cart'));
    }


    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        $productId = $product->id;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image_path" => $product->image_path 
            ];
        }

        session()->put('cart', $cart); 

        return redirect()->back()->with('success', $product->name . ' added to cart!');
    }


    public function update(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        $productId = $product->id;
        $quantity = $request->input('quantity');

        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $quantity;
            }

            session()->put('cart', $cart); 
            return redirect()->back()->with('success', 'Cart updated successfully!');

        }

        return redirect()->back()->with('error', 'Product not found in cart!');
    }

 
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        $productId = $product->id;

        if (isset($cart[$productId])) {
            unset($cart[$productId]); 
            session()->put('cart', $cart);
            return redirect()->back()->with('success', $product->name . ' removed from cart!');
        }

        return redirect()->back()->with('error', 'Product not found in cart!');
    }

    
    public function clear()
    {
        session()->forget('cart'); 
        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }
}