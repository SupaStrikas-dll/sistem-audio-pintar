<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\PerantiAudio;
use App\Models\Cadangan;
use App\Models\Ulasan;
use App\Models\User;
use App\Models\PilihanPengguna;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahPengguna = User::where('peranan', 'pengguna')->count();
        $jumlahPeranti  = PerantiAudio::count();
        $jumlahCadangan = Cadangan::count();
        $jumlahUlasan   = Ulasan::count();
        $perantiTerkini = PerantiAudio::with('kategori')->latest()->take(5)->get();

        // Kira peratusan carian setiap kategori (data sebenar)
        $jumlahCarian = PilihanPengguna::count();
        $kategoriList = Kategori::all();
        $kategoriPopular = $kategoriList->map(function ($k) use ($jumlahCarian) {
            $bilangan = PilihanPengguna::where('jenis', $k->nama_kategori)->count();
            $peratus  = $jumlahCarian > 0 ? round(($bilangan / $jumlahCarian) * 100) : 0;
            return [
                'nama'    => $k->nama_kategori,
                'peratus' => $peratus,
            ];
        })->sortByDesc('peratus')->values();

        return view('admin.dashboard', compact(
            'jumlahPengguna',
            'jumlahPeranti',
            'jumlahCadangan',
            'jumlahUlasan',
            'perantiTerkini',
            'kategoriPopular'
        ));
    }
}
