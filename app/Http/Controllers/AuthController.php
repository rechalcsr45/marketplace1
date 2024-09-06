<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegisterForm(){
        return view('register');
    }

    public function register(Request $request){
        
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'alamat' => 'required|string',
            'no_telp' => 'required',
            'role'=> 'required|in:1,2',
        ]);
        


        // Membuat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'role' => $request->role,
        ]);

        // Login pengguna secara otomatis setelah registrasi
        auth()->login($user);

        // Redirect ke halaman setelah login
        return redirect()->intended('/home');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
    
            // Redirect berdasarkan role
            if ($user->role == 1) {
                return redirect()->route('seller.dashboard');
            } elseif ($user->role == 2) {
                return redirect()->route('buyer.dashboard');
            }
        }
    
        return back()->withErrors(['email' => 'Email atau Password salah'])->onlyInput('email');

    }

    public function showLoginForm()
    {
        return view('login');
    }
}
