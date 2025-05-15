<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class ProductController extends Controller
{

/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
/*******  1005a901-ebb1-4130-8e2d-46fdf8dfc605  *******/
public function index() {
    $products = Product::all();
    return view('products.index', compact('products'));
}

public function create() {
    return view('products.create');
}

public function store(Request $request) {
    $validated = $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'image|mimes:jpeg,png,jpg'
    ]);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $validated['image'] = $path;
    }

    Product::create($validated);
    return redirect()->route('products.index');
}

}
