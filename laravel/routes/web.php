<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CadanganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SejarahController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PerantiDetailController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PenggunaController as AdminPenggunaController;
use App\Http\Controllers\Admin\PerantiController as AdminPerantiController;
use App\Http\Controllers\Admin\CadanganController as AdminCadanganController;
use App\Http\Controllers\Admin\UlasanController as AdminUlasanController;
use App\Http\Controllers\Admin\StatistikController as AdminStatistikController;
use App\Http\Controllers\Admin\TetapanController as AdminTetapanController;

// =====================================================
// HOMEPAGE
// =====================================================
Route::get('/', function () {
    return view('landing');
})->name('landing');

// =====================================================
// AUTHENTICATION
// =====================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'halamanLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'prosesLogin'])->name('prosesLogin');
    Route::get('/daftar', [AuthController::class, 'halamanDaftar'])->name('daftar');
    Route::post('/daftar', [AuthController::class, 'prosesDaftar'])->name('prosesDaftar');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================================================
// ROUTE PENGGUNA
// =====================================================
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('pengguna.dashboard');

    // Borang Keutamaan & Cadangan
    Route::get('/keutamaan', [CadanganController::class, 'borang'])
        ->name('keutamaan.borang');
    Route::post('/keutamaan', [CadanganController::class, 'simpanPilihan'])
        ->name('keutamaan.simpan');
    Route::get('/cadangan/{id}', [CadanganController::class, 'hasilCadangan'])
        ->name('cadangan.hasil');

    // Sejarah Cadangan
    Route::get('/sejarah', [SejarahController::class, 'index'])
        ->name('sejarah.index');

    // Ulasan
    Route::get('/ulasan', [UlasanController::class, 'index'])
        ->name('ulasan.index');
    Route::post('/ulasan', [UlasanController::class, 'simpan'])
        ->name('ulasan.simpan');
    Route::delete('/ulasan/{id}', [UlasanController::class, 'padam'])
        ->name('ulasan.padam');

    // Profil Pengguna
    Route::get('/profil', [ProfilController::class, 'index'])
        ->name('profil.index');
    Route::put('/profil', [ProfilController::class, 'kemaskini'])
        ->name('profil.kemaskini');
    Route::put('/profil/kata-laluan', [ProfilController::class, 'tukarKataLaluan'])
        ->name('profil.tukarKataLaluan');

    // Detail Peranti
    Route::get('/peranti/{id}', [PerantiDetailController::class, 'index'])
        ->name('peranti.detail');

});

// =====================================================
// ROUTE ADMIN
// =====================================================
Route::middleware('auth')->prefix('admin')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Pengurusan Pengguna
    Route::get('/pengguna', [AdminPenggunaController::class, 'index'])
        ->name('admin.pengguna');
    Route::delete('/pengguna/{id}/padam', [AdminPenggunaController::class, 'padam'])
        ->name('admin.pengguna.padam');

    // CRUD Peranti Audio
    Route::get('/peranti', [AdminPerantiController::class, 'index'])
        ->name('admin.peranti');
    Route::get('/peranti/eksport', [AdminPerantiController::class, 'export'])
        ->name('admin.peranti.eksport');
    Route::get('/peranti/tambah', [AdminPerantiController::class, 'tambah'])
        ->name('admin.peranti.tambah');
    Route::post('/peranti/simpan', [AdminPerantiController::class, 'simpan'])
        ->name('admin.peranti.simpan');
    Route::get('/peranti/{id}/kemaskini', [AdminPerantiController::class, 'kemaskini'])
        ->name('admin.peranti.kemaskini');
    Route::put('/peranti/{id}/update', [AdminPerantiController::class, 'update'])
        ->name('admin.peranti.update');
    Route::delete('/peranti/{id}/padam', [AdminPerantiController::class, 'padam'])
        ->name('admin.peranti.padam');

    // Cadangan
    Route::get('/cadangan', [AdminCadanganController::class, 'index'])
        ->name('admin.cadangan');

    // Ulasan
    Route::get('/ulasan', [AdminUlasanController::class, 'index'])
        ->name('admin.ulasan');
    Route::delete('/ulasan/{id}/padam', [AdminUlasanController::class, 'padam'])
        ->name('admin.ulasan.padam');

    // Statistik
    Route::get('/statistik', [AdminStatistikController::class, 'index'])
        ->name('admin.statistik');
    Route::get('/statistik/eksport', [AdminStatistikController::class, 'export'])
        ->name('admin.statistik.eksport');

    // Tetapan
    Route::get('/tetapan', [AdminTetapanController::class, 'index'])
        ->name('admin.tetapan');
    Route::put('/tetapan', [AdminTetapanController::class, 'kemaskini'])
        ->name('admin.tetapan.kemaskini');
    Route::put('/tetapan/kata-laluan', [AdminTetapanController::class, 'kataLaluan'])
        ->name('admin.tetapan.kataLaluan');

});
