<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CadanganController;

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

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================================================
// ROUTE PENGGUNA
// =====================================================
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('pengguna.dashboard');
    })->name('pengguna.dashboard');

    // Borang Keutamaan Audio
    Route::get('/keutamaan', function () {
        return view('pengguna.borang_keutamaan');
    })->name('keutamaan.borang');

    // Simpan pilihan & jana cadangan
    Route::post('/keutamaan', [CadanganController::class, 'simpanPilihan'])
        ->name('keutamaan.simpan');

    // Hasil cadangan
    Route::get('/cadangan/{id}', [CadanganController::class, 'hasilCadangan'])
        ->name('cadangan.hasil');

    // Sejarah cadangan
    Route::get('/sejarah', function () {
        $sejarah = App\Models\PilihanPengguna::with('cadangan.peranti.kategori')
            ->where('id_pengguna', auth()->id())
            ->latest()
            ->get();
        return view('pengguna.sejarah', compact('sejarah'));
    })->name('sejarah.index');

    // Ulasan
    Route::get('/ulasan', function () {
        $ulasan = App\Models\Ulasan::with('peranti', 'pengguna')
            ->latest()
            ->get();
        $senaraiPeranti = App\Models\PerantiAudio::where('status', 1)->get();
        return view('pengguna.ulasan', compact('ulasan', 'senaraiPeranti'));
    })->name('ulasan.index');

    Route::post('/ulasan', function (Illuminate\Http\Request $request) {
        $request->validate([
            'id_peranti' => 'required|exists:peranti_audio,id',
            'penilaian'  => 'required|integer|min:1|max:5',
            'komen'      => 'nullable|string|max:500',
        ], [
            'id_peranti.required' => 'Sila pilih peranti.',
            'penilaian.required'  => 'Sila beri penilaian bintang.',
            'penilaian.min'       => 'Penilaian minimum 1 bintang.',
        ]);

        App\Models\Ulasan::create([
            'id_pengguna' => auth()->id(),
            'id_peranti'  => $request->id_peranti,
            'penilaian'   => $request->penilaian,
            'komen'       => $request->komen,
            'tarikh'      => now(),
        ]);

        return back()->with('berjaya', 'Ulasan berjaya dihantar!');
    })->name('ulasan.simpan');

    Route::delete('/ulasan/{id}', function ($id) {
        $ulasan = App\Models\Ulasan::where('id', $id)
            ->where('id_pengguna', auth()->id())
            ->firstOrFail();
        $ulasan->delete();
        return back()->with('berjaya', 'Ulasan berjaya dipadam!');
    })->name('ulasan.padam');

    // Profil
    Route::get('/profil', function () {
        return view('pengguna.profil');
    })->name('profil.index');

    Route::put('/profil', function (Illuminate\Http\Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'emel' => 'required|email|unique:users,emel,' . auth()->id(),
        ], [
            'nama.required' => 'Sila masukkan nama.',
            'emel.required' => 'Sila masukkan emel.',
            'emel.unique'   => 'Emel ini sudah digunakan.',
        ]);

        auth()->user()->update([
            'nama' => $request->nama,
            'emel' => $request->emel,
        ]);

        return back()->with('berjaya', 'Profil berjaya dikemaskini!');
    })->name('profil.kemaskini');

    Route::put('/profil/kata-laluan', function (Illuminate\Http\Request $request) {
        $request->validate([
            'kata_laluan_semasa' => 'required',
            'kata_laluan_baru'   => 'required|min:6|confirmed',
        ], [
            'kata_laluan_semasa.required' => 'Sila masukkan kata laluan semasa.',
            'kata_laluan_baru.required'   => 'Sila masukkan kata laluan baru.',
            'kata_laluan_baru.min'        => 'Kata laluan minimum 6 aksara.',
            'kata_laluan_baru.confirmed'  => 'Pengesahan kata laluan tidak sepadan.',
        ]);

        if (!Hash::check($request->kata_laluan_semasa, auth()->user()->kata_laluan)) {
            return back()->withErrors(['kata_laluan_semasa' => 'Kata laluan semasa tidak betul.']);
        }

        auth()->user()->update([
            'kata_laluan' => Hash::make($request->kata_laluan_baru),
        ]);

        return back()->with('berjaya', 'Kata laluan berjaya ditukar!');
    })->name('profil.tukarKataLaluan');

});

// =====================================================
// ROUTE ADMIN
// =====================================================
Route::middleware('auth')->prefix('admin')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', function () {
        $jumlahPengguna = App\Models\User::where('peranan', 'pengguna')->count();
        $jumlahPeranti  = App\Models\PerantiAudio::count();
        $jumlahCadangan = App\Models\Cadangan::count();
        $jumlahUlasan   = App\Models\Ulasan::count();
        $perantiTerkini = App\Models\PerantiAudio::with('kategori')->latest()->take(5)->get();
        return view('admin.dashboard', compact(
            'jumlahPengguna', 'jumlahPeranti',
            'jumlahCadangan', 'jumlahUlasan',
            'perantiTerkini'
        ));
    })->name('admin.dashboard');

    // Pengurusan Pengguna
    Route::get('/pengguna', function () {
        $pengguna = App\Models\User::where('peranan', 'pengguna')->latest()->paginate(10);
        return view('admin.pengguna', compact('pengguna'));
    })->name('admin.pengguna');

    // CRUD Peranti Audio
    Route::get('/peranti', [App\Http\Controllers\Admin\PerantiController::class, 'index'])
        ->name('admin.peranti');
    Route::get('/peranti/tambah', [App\Http\Controllers\Admin\PerantiController::class, 'tambah'])
        ->name('admin.peranti.tambah');
    Route::post('/peranti/simpan', [App\Http\Controllers\Admin\PerantiController::class, 'simpan'])
        ->name('admin.peranti.simpan');
    Route::get('/peranti/{id}/kemaskini', [App\Http\Controllers\Admin\PerantiController::class, 'kemaskini'])
        ->name('admin.peranti.kemaskini');
    Route::put('/peranti/{id}/update', [App\Http\Controllers\Admin\PerantiController::class, 'update'])
        ->name('admin.peranti.update');
    Route::delete('/peranti/{id}/padam', [App\Http\Controllers\Admin\PerantiController::class, 'padam'])
        ->name('admin.peranti.padam');

});