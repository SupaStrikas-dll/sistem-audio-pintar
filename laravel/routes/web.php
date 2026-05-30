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

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================================================
// ROUTE PENGGUNA
// =====================================================
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $userId = auth()->id();

        $jumlahCadangan = App\Models\Cadangan::whereHas('pilihan', function($q) use ($userId) {
            $q->where('id_pengguna', $userId);
        })->count();

        $jumlahUlasan = App\Models\Ulasan::where('id_pengguna', $userId)->count();

        $jumlahPerantiDilihat = App\Models\PilihanPengguna::where('id_pengguna', $userId)->count();

        $cadanganTerkini = App\Models\Cadangan::with('peranti.kategori')
            ->whereHas('pilihan', function($q) use ($userId) {
                $q->where('id_pengguna', $userId);
            })
            ->orderBy('skor_padanan', 'desc')
            ->take(3)
            ->get();

        $sejarahTerkini = App\Models\PilihanPengguna::with('cadangan')
            ->where('id_pengguna', $userId)
            ->latest()
            ->take(3)
            ->get();

        return view('pengguna.dashboard', compact(
            'jumlahCadangan',
            'jumlahUlasan',
            'jumlahPerantiDilihat',
            'cadanganTerkini',
            'sejarahTerkini'
        ));
    })->name('pengguna.dashboard');

    // Borang Keutamaan
    Route::get('/keutamaan', function () {
        return view('pengguna.borang_keutamaan');
    })->name('keutamaan.borang');

    Route::post('/keutamaan', [CadanganController::class, 'simpanPilihan'])
        ->name('keutamaan.simpan');

    // Hasil Cadangan
    Route::get('/cadangan/{id}', [CadanganController::class, 'hasilCadangan'])
        ->name('cadangan.hasil');

    // Sejarah Cadangan
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
        $senaraiPeranti = App\Models\PerantiAudio::with('kategori')->get();
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

        // Kemaskini skor purata peranti
        $peranti = App\Models\PerantiAudio::find($request->id_peranti);
        if ($peranti) {
            $skorPurata = App\Models\Ulasan::where('id_peranti', $request->id_peranti)->avg('penilaian');
            $peranti->update(['skor_purata' => round($skorPurata, 2)]);
        }

        return back()->with('berjaya', 'Ulasan berjaya dihantar!');
    })->name('ulasan.simpan');

    Route::delete('/ulasan/{id}', function ($id) {
        $ulasan = App\Models\Ulasan::where('id', $id)
            ->where('id_pengguna', auth()->id())
            ->firstOrFail();

        $idPeranti = $ulasan->id_peranti;
        $ulasan->delete();

        // Kemaskini semula skor purata
        $peranti = App\Models\PerantiAudio::find($idPeranti);
        if ($peranti) {
            $skorPurata = App\Models\Ulasan::where('id_peranti', $idPeranti)->avg('penilaian');
            $peranti->update(['skor_purata' => round($skorPurata ?? 0, 2)]);
        }

        return back()->with('berjaya', 'Ulasan berjaya dipadam!');
    })->name('ulasan.padam');

    // Profil Pengguna
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

    // Detail Peranti
    Route::get('/peranti/{id}', function ($id) {
        $peranti = App\Models\PerantiAudio::with('kategori', 'ulasan.pengguna')
            ->findOrFail($id);
        return view('pengguna.detail_peranti', compact('peranti'));
    })->name('peranti.detail');

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
            'jumlahPengguna',
            'jumlahPeranti',
            'jumlahCadangan',
            'jumlahUlasan',
            'perantiTerkini'
        ));
    })->name('admin.dashboard');

    // Pengurusan Pengguna
    Route::get('/pengguna', function (Illuminate\Http\Request $request) {
        $query = App\Models\User::query();
        if ($request->cari) {
            $query->where('nama', 'like', '%' . $request->cari . '%')
                ->orWhere('emel', 'like', '%' . $request->cari . '%');
        }
        $pengguna = $query->latest()->paginate(10);
        return view('admin.pengguna', compact('pengguna'));
    })->name('admin.pengguna');

    Route::delete('/pengguna/{id}/padam', function ($id) {
        App\Models\User::findOrFail($id)->delete();
        return back()->with('berjaya', 'Pengguna berjaya dipadam!');
    })->name('admin.pengguna.padam');

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

    // Cadangan
    Route::get('/cadangan', function () {
        $cadangan = App\Models\Cadangan::with('pilihan.pengguna', 'peranti')
            ->latest()->paginate(10);
        return view('admin.cadangan', compact('cadangan'));
    })->name('admin.cadangan');

    // Ulasan
    Route::get('/ulasan', function () {
        $ulasan = App\Models\Ulasan::with('pengguna', 'peranti')
            ->latest()->paginate(10);
        return view('admin.ulasan', compact('ulasan'));
    })->name('admin.ulasan');

    Route::delete('/ulasan/{id}/padam', function ($id) {
        App\Models\Ulasan::findOrFail($id)->delete();
        return back()->with('berjaya', 'Ulasan berjaya dipadam!');
    })->name('admin.ulasan.padam');

    // Statistik
    Route::get('/statistik', function () {
        $jumlahPengguna  = App\Models\User::where('peranan', 'pengguna')->count();
        $jumlahPeranti   = App\Models\PerantiAudio::count();
        $jumlahCadangan  = App\Models\Cadangan::count();
        $jumlahUlasan    = App\Models\Ulasan::count();
        $perantiPopular  = App\Models\PerantiAudio::withCount('cadangan as jumlah_cadangan')
            ->orderBy('jumlah_cadangan', 'desc')->take(5)->get();
        $kategoriPopular = App\Models\Kategori::withCount(['peranti as jumlah' => function ($q) {
            $q->whereHas('cadangan');
        }])->orderBy('jumlah', 'desc')->get();
        return view('admin.statistik', compact(
            'jumlahPengguna',
            'jumlahPeranti',
            'jumlahCadangan',
            'jumlahUlasan',
            'perantiPopular',
            'kategoriPopular'
        ));
    })->name('admin.statistik');

    // Tetapan
    Route::get('/tetapan', function () {
        return view('admin.tetapan');
    })->name('admin.tetapan');

    Route::put('/tetapan', function (Illuminate\Http\Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'emel' => 'required|email|unique:users,emel,' . auth()->id(),
        ]);
        auth()->user()->update([
            'nama' => $request->nama,
            'emel' => $request->emel,
        ]);
        return back()->with('berjaya', 'Maklumat berjaya dikemaskini!');
    })->name('admin.tetapan.kemaskini');

    Route::put('/tetapan/kata-laluan', function (Illuminate\Http\Request $request) {
        $request->validate([
            'kata_laluan_semasa' => 'required',
            'kata_laluan_baru'   => 'required|min:6|confirmed',
        ]);
        if (!Hash::check($request->kata_laluan_semasa, auth()->user()->kata_laluan)) {
            return back()->withErrors(['kata_laluan_semasa' => 'Kata laluan semasa tidak betul.']);
        }
        auth()->user()->update([
            'kata_laluan' => Hash::make($request->kata_laluan_baru),
        ]);
        return back()->with('berjaya', 'Kata laluan berjaya ditukar!');
    })->name('admin.tetapan.kataLaluan');

});