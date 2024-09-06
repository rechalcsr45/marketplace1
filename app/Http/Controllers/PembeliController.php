<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembeliController extends Controller
{
    public function index()
    {
        return view('buyer.dashboard');
    }
}
