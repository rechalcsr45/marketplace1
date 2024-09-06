<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PenjualController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('seller.dashboard', compact('products'));
    }
}
