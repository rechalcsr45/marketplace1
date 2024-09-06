<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Pastikan model Product diimport
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource (marketplace).
     */
    public function index()
    {
        // Mengambil semua produk dari database
        $products = Product::all();

        // Mengembalikan view dengan data produk
        return view('login', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource (product).
     */
    public function create()
    {
        return view('products.create'); // View untuk menambahkan produk baru
    }

    /**
     * Store a newly created resource in storage (product).
     */
    public function store(Request $request)
    {
        $request->validate([
            'product' => 'required|string|max:255',
            'description' => 'required|string',
            'harga' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        Product::create($request->all());

        return redirect()->route('home.index')->with('success', 'Product added successfully!');
    }

    /**
     * Display the specified resource (product).
     */
    public function show(Product $product)
    {
        return view('products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource (product).
     */
    public function edit(Product $product)
    {
        return view('products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage (product).
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product' => 'required|string|max:255',
            'description' => 'required|string',
            'harga' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product->update($request->all());

        return redirect()->route('home.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage (product).
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('home.index')->with('success', 'Product deleted successfully!');
    }

    /**
     * Handle the logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout(); // Logout user

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate token to prevent CSRF attacks
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out!');
    }
}
