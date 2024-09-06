<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product' => 'required|string|max:255',
            'description' => 'required|string',
            'harga' => 'required|numeric',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if($request->hasFile('foto')){
            $image = $request->file('foto');
            $image_extension = $image->getClientOriginalExtension();
            $image_name = time() . '.' . $image_extension;
            $image_folder = '/photo/products/';
            $image_location = $image_folder . $image_name;
            $image->move(public_path($image_folder), $image_name);
            Product::create([
                'product' => $request->product,
                'description' => $request->description,
                'harga' => $request->harga,
                'foto' => $image_location, // Simpan path foto
            ]);
        } else{
            Product::create([
                'product' => $request->product,
                'description' => $request->description,
                'harga' => $request->harga,
            ]);
        }

        // Menyimpan produk ke database
        
        return redirect()->route('product.index')->with(['success' => 'Produk Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('product.show', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

        
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'product' => 'required',
            'description' => 'required',
            'harga' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($product->foto) {
                Storage::disk('public')->delete($product->foto);
            }
            // Simpan foto baru
            $fotoPath = $request->file('foto')->store('photos', 'public');
        } else {
            $fotoPath = $product->foto;
        }

        $product->update([
            'id_product' => $request->id_product,
            'product' => $request->product,
            'description' => $request->description,
            'harga' => $request->harga,
            'foto' => $fotoPath,
        ]);
        return redirect()->route('product.index')->with(['success' => 'Produk Berhasil Disimpan!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Hapus foto dari penyimpanan
        if ($product->foto) {
            Storage::disk('public')->delete($product->foto);
        }

        $product->delete();

        return redirect()->route('product.index')->with(['success' => 'Produk Berhasil Dihapus!']);
    
    }
}
