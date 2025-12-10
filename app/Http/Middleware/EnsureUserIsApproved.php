<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check())
            return redirect()->route('login');

        $user = Auth::user();
        if ($user->role === 'admin')
            return $next($request);

        // A. KASUS REJECTED (DITOLAK)
        // User WAJIB diarahkan ke halaman Profil untuk perbaikan
        if ($user->status === 'rejected') {
            // Izinkan akses hanya ke halaman profil (edit/update) dan logout
            if (
                $request->routeIs('profile.edit') ||
                $request->routeIs('profile.update') ||
                $request->routeIs('logout')
            ) {
                return $next($request);
            }

            // Jika coba buka halaman lain (termasuk waiting), lempar ke Profil
            return redirect()->route('profile.edit');
        }

        // B. KASUS PENDING (MENUNGGU)
        // User diarahkan ke halaman Waiting
        if ($user->status === 'pending') {
            // Izinkan akses ke waiting, profil (edit/update), dan logout
            if (
                $request->routeIs('waiting') ||
                $request->routeIs('profile.edit') ||
                $request->routeIs('profile.update') ||
                $request->routeIs('logout')
            ) {
                return $next($request);
            }

            // Selain itu, lempar ke Waiting
            return redirect()->route('waiting');
        }

        // C. KASUS APPROVED (SUDAH ACC)
        // Kalau user iseng buka halaman waiting, lempar ke cari jodoh
        if ($user->status === 'approved' && $request->routeIs('waiting')) {
            return redirect()->route('match.result');
        }

        return $next($request);
    }
}