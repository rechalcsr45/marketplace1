<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'user' => $products,

        ], 200);
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
            'foto' => 'required',
        ]);

        $product = Product::create($request->all());
        return response()->json($product, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id_produk)
    {
        $products = Product::find($id_produk);

        if (!$products) {
            return response()->json(['message' => 'Product Tidak Tersedia'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($products, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_produk)
    {
        $product = Product::find($id_produk);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'product' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'harga' => 'sometimes|numeric',
            'foto' => 'sometimes|integer',
        ]);

        $product->update($request->all());
        return response()->json($product, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_produk)
    {
        $product = Product::find($id_produk);
        if(empty($product)){
            return response()->json([
                'status' => false,
                'message' => 'Sukses Malakukan Delete Data'
            ], 404);
        }

        $post = $product->delete();

        return response()->json([
            'status'=>true,
            'message'=>'Sukses Melakukan Delete Data'
        ]);
    }
}