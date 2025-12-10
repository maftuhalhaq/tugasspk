<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek Login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek Role
        // Kalau role-nya BUKAN admin, tendang ke halaman utama atau error 403
        if (Auth::user()->role !== 'admin') {
            abort(403, 'ANDA BUKAN ADMIN! DILARANG MASUK.');
        }

        // Kalau Admin, silakan lewat
        return $next($request);
    }
}