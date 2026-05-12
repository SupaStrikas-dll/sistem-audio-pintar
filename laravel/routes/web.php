<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Homepage
Route::get('/', function () {
    return view('landing');
})->name('landing');

// --- ADDED THESE ROUTES TO FIX THE ERROR ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/daftar', [AuthController::class, 'showRegister'])->name('daftar');
// -------------------------------------------

// Route Authentication
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('pengguna.dashboard');
    })->name('pengguna.dashboard');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route pengguna - sementara tanpa auth untuk test UI
// Note: This overrides the one inside the middleware above because it's defined later
Route::get('/temp-dashboard', function () {
    return view('pengguna.dashboard');
})->name('temp.dashboard');

// Route admin - sementara tanpa auth untuk test UI
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');