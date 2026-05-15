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
    Route::post('/login', [AuthController::class, 'prosesLogin'])->name('prosesLogin');
    Route::get('/daftar', [AuthController::class, 'halamanDaftar'])->name('daftar');
    Route::post('/daftar', [AuthController::class, 'prosesDaftar'])->name('prosesDaftar');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route pengguna — semua dalam satu group
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('pengguna.dashboard');
    })->name('pengguna.dashboard');

    Route::get('/keutamaan', function () {
        return view('pengguna.borang_keutamaan');
    })->name('keutamaan.borang');

    Route::post('/keutamaan', function () {
        // Logic simpan — buat lepas ni
    })->name('keutamaan.simpan');

    Route::get('/cadangan', function () {
        return view('pengguna.cadangan');
    })->name('cadangan.hasil');

    // Ulasan
    Route::get('/ulasan', function () {
    return view('pengguna.ulasan');
    })->name('ulasan.index');

    Route::post('/ulasan', function () {
    // Logic simpan — buat lepas ni
    })->name('ulasan.simpan');

    Route::delete('/ulasan/{id}', function ($id) {
    // Logic padam — buat lepas ni
    })->name('ulasan.padam');
});

// Route admin
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // CRUD Peranti
    Route::get('/peranti', [App\Http\Controllers\Admin\PerantiController::class, 'index'])->name('admin.peranti');
    Route::get('/peranti/tambah', [App\Http\Controllers\Admin\PerantiController::class, 'tambah'])->name('admin.peranti.tambah');
    Route::post('/peranti/simpan', [App\Http\Controllers\Admin\PerantiController::class, 'simpan'])->name('admin.peranti.simpan');
    Route::get('/peranti/{id}/kemaskini', [App\Http\Controllers\Admin\PerantiController::class, 'kemaskini'])->name('admin.peranti.kemaskini');
    Route::put('/peranti/{id}/update', [App\Http\Controllers\Admin\PerantiController::class, 'update'])->name('admin.peranti.update');
    Route::delete('/peranti/{id}/padam', [App\Http\Controllers\Admin\PerantiController::class, 'padam'])->name('admin.peranti.padam');
});