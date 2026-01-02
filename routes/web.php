<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Import Semua Controller
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes - Cupid AI (Final Version)
|--------------------------------------------------------------------------
*/

// ====================================================
// 1. RUTE PUBLIK (LANDING PAGE)
// ====================================================

Route::get('/', function () {
    // Logika Redirect Cerdas jika user iseng buka halaman utama saat sudah login
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if ($user->status == 'approved') {
            return redirect()->route('match.result');
        }
        if ($user->status == 'rejected') {
            return redirect()->route('profile.edit');
        }
        return redirect()->route('waiting');
    }
    return view('welcome');
});


// ====================================================
// 2. OTENTIKASI (LOGIN / REGISTER / LOGOUT)
// ====================================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'processRegister']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


// ====================================================
// 3. RUTE TER-AUTENTIKASI (Harus Login)
// ====================================================

Route::middleware(['auth'])->group(function () {

    // --- A. ZONA UMUM (Bisa diakses Status: Pending & Approved) ---
    // User baru daftar wajib bisa akses ini untuk melengkapi data

    // 1. Edit Profil (Foto, WA, IG, Data Diri)
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profil', [ProfileController::class, 'update'])->name('profile.update');

    // 2. Ruang Tunggu (Waiting Room)
    Route::get('/menunggu-verifikasi', function () {
        $user = Auth::user();

        // Admin jangan masuk sini
        if ($user->role == 'admin')
            return redirect()->route('admin.dashboard');

        // User yang sudah di-acc ngapain nunggu?
        if ($user->status == 'approved')
            return redirect()->route('match.result');

        return view('waiting');
    })->name('waiting');


    // --- B. ZONA KHUSUS USER APPROVED (Middleware 'approved') ---
    // User 'pending' akan ditendang balik ke 'waiting' oleh middleware ini
    Route::middleware(['approved'])->group(function () {

        // 1. Dashboard Utama (Hasil Pencarian)
        Route::get('/cari-jodoh', [MatchController::class, 'index'])->name('match.result');

        // 2. Form Kriteria (Filter Umur, Gaji, dll)
        Route::get('/atur-kriteria', [MatchController::class, 'criteriaForm'])->name('match.form');
        Route::post('/atur-kriteria', [MatchController::class, 'updateCriteria']);

        // 3. Rekam Interaksi (Klik Tombol WA)
        Route::post('/record-interaction/{id}', [MatchController::class, 'recordInteraction'])->name('interaction.record');
    });


    // --- C. ZONA ADMIN (Middleware 'admin') ---
    // Hanya Admin yang boleh masuk
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

        // 1. Dashboard Statistik
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // 2. Manajemen User (ACC / Tolak)
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users/{id}/approve', [AdminController::class, 'approveUser'])->name('users.approve');
        Route::post('/users/{id}/reject', [AdminController::class, 'rejectUser'])->name('users.reject');
        Route::post('/users/{id}/delete', [AdminController::class, 'deleteUser'])->name('users.delete');

        // 3. Konfigurasi Bobot SPK
        Route::get('/weights', [AdminController::class, 'weights'])->name('weights');
        Route::post('/weights', [AdminController::class, 'updateWeight']);
        Route::post('/weights/reset', [AdminController::class, 'resetCriteriaWeights'])->name('weights.reset');

        // 4. Cetak Laporan
        Route::get('/print', [AdminController::class, 'printReport'])->name('print');
    });

});
