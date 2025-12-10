<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

// --- 1. HALAMAN PUBLIK (Bisa diakses tanpa login) ---
Route::get('/', function () {
    return redirect('/login'); // Redirect awal ke login
});

// Route Login & Register
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'processRegister']);
Route::post('/logout', [AuthController::class, 'logout']);


// --- 2. HALAMAN DIBATASI (Harus Login Dulu) ---
// Kita bungkus pakai Middleware 'auth'
Route::middleware(['auth'])->group(function () {

    // A. Fitur User Biasa (Pencari Jodoh)
    Route::get('/cari-jodoh', [MatchController::class, 'index']);
    Route::get('/atur-kriteria', [MatchController::class, 'edit']);
    Route::post('/atur-kriteria', [MatchController::class, 'update']);
    Route::get('/profil', [MatchController::class, 'editProfile']);
    Route::post('/profil', [MatchController::class, 'updateProfile']);

    // B. Fitur Admin (Khusus Role Admin)
    // Sebaiknya tambahkan middleware check role disini, tapi manual dulu oke.
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/bobot', [AdminController::class, 'editWeights']);
        Route::post('/bobot', [AdminController::class, 'updateWeights']);
        Route::get('/users', [AdminController::class, 'usersList']);
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
    });

});