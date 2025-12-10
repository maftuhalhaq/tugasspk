<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    // --- FITUR REGISTER ---
    public function showRegister()
    {
        return view('auth.register');
    }

    public function processRegister(Request $request)
    {
        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Buat User Baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'status' => 'pending', // Penting: Status awal pending
        ]);

        // Kirim Event Registered (Penyebab Error Tadi)
        event(new Registered($user));

        // Login Otomatis
        Auth::login($user);

        // Redirect ke Profil
        return redirect('/profil')->with('success', 'Akun berhasil dibuat! Silakan lengkapi data diri.');
    }

    // --- FITUR LOGIN ---
    public function showLogin()
    {
        return view('auth.login');
    }

    public function processLogin(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Coba Login (Auth::attempt)
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Security: Cegah session fixation

            // 3. Cek Role: Admin ke Dashboard, User ke Cari Jodoh
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            }

            // Kalau profilnya masih kosong, suruh isi dulu
            if ($user->income_level == 0 || $user->gender == null) {
                return redirect('/profil')->with('warning', 'Halo warga baru! Lengkapi profilmu dulu ya.');
            }

            return redirect('/cari-jodoh');
        }

        // Kalau Gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // --- FITUR LOGOUT ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}