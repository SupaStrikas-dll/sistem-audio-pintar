<?php

namespace App\Http\Controllers;

use App\Models\Cadangan;
use App\Models\PilihanPengguna;
use App\Models\Ulasan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $jumlahCadangan = Cadangan::whereHas('pilihan', function ($q) use ($userId) {
            $q->where('id_pengguna', $userId);
        })->count();

        $jumlahUlasan = Ulasan::where('id_pengguna', $userId)->count();

        $jumlahPerantiDilihat = PilihanPengguna::where('id_pengguna', $userId)->count();

        $cadanganTerkini = Cadangan::with('peranti.kategori')
            ->whereHas('pilihan', function ($q) use ($userId) {
                $q->where('id_pengguna', $userId);
            })
            ->orderBy('skor_padanan', 'desc')
            ->take(3)
            ->get();

        $sejarahTerkini = PilihanPengguna::with('cadangan')
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
    }
}
