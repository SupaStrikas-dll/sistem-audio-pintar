<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Homepage
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Route Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'halamanLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'prosesLogin']);
    Route::get('/daftar', [AuthController::class, 'halamanDaftar'])->name('daftar');
    Route::post('/daftar', [AuthController::class, 'prosesDaftar']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route pengguna
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('pengguna.dashboard');
    })->name('pengguna.dashboard');
});

// Route admin
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});