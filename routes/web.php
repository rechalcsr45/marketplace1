<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PenjualController;
use App\Http\Controllers\ProductController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::GET('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register-user', [AuthController::class, 'register'])->name('register-user');
Route::get('/login',[AuthController::class,'showLoginForm'])->name('login');
Route::post('/login-user',[AuthController::class,'login'])->name('login-user');
Route::post('/logout', [HomeController::class, 'logout'])->name('logout');
Route::post('/profile', [HomeController::class, 'profile'])->name('profile');


Route::middleware(['auth', 'role:1'])->group(function () {
    // Rute khusus penjual
    Route::get('/seller/dashboard', [PenjualController::class, 'index'])->name('seller.dashboard');
    // Tambahkan rute penjual lainnya di sini...
});

Route::middleware(['auth', 'role:2'])->group(function () {
    // Rute khusus pembeli
    Route::get('/buyer/dashboard', [PembeliController::class, 'index'])->name('buyer.dashboard');
    // Tambahkan rute pembeli lainnya di sini...
});

Route::resource('home', HomeController::class)->middleware('auth');
Route::resource('product',ProductController::class);

