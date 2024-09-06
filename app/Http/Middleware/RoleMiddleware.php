<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Memeriksa apakah pengguna terautentikasi
        if (Auth::check()) {
            // Memeriksa apakah pengguna memiliki role yang sesuai
            if (Auth::user()->role == $role) {
                return $next($request);
            }
        }

        // Jika pengguna tidak memiliki akses, arahkan ke halaman 403 Forbidden atau halaman lain yang sesuai
        return abort(403, 'Unauthorized action.');
    }
}
