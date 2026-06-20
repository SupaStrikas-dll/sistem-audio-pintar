<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PerantiAudio;
use App\Models\Cadangan;
use App\Models\Ulasan;
use App\Models\Kategori;

class StatistikController extends Controller
{
    public function index()
    {
        $jumlahPengguna  = User::where('peranan', 'pengguna')->count();
        $jumlahPeranti   = PerantiAudio::count();
        $jumlahCadangan  = Cadangan::count();
        $jumlahUlasan    = Ulasan::count();

        $perantiPopular  = PerantiAudio::withCount('cadangan as jumlah_cadangan')
            ->orderBy('jumlah_cadangan', 'desc')->take(5)->get();

        // Kira peratusan carian setiap kategori (data sebenar)
        $jumlahCarian = \App\Models\PilihanPengguna::count();
        $kategoriList = Kategori::all();
        $kategoriPopular = $kategoriList->map(function ($k) use ($jumlahCarian) {
            $bilangan = \App\Models\PilihanPengguna::where('jenis', $k->nama_kategori)->count();
            $peratus  = $jumlahCarian > 0 ? round(($bilangan / $jumlahCarian) * 100) : 0;
            return [
                'nama'    => $k->nama_kategori,
                'peratus' => $peratus,
            ];
        })->sortByDesc('peratus')->values();

        return view('admin.statistik', compact(
            'jumlahPengguna',
            'jumlahPeranti',
            'jumlahCadangan',
            'jumlahUlasan',
            'perantiPopular',
            'kategoriPopular'
        ));
    }

    // =====================================================
    // EKSPORT LAPORAN STATISTIK (CSV — boleh buka terus dalam Excel)
    // =====================================================
    public function export()
    {
        $peranti = PerantiAudio::with('kategori')
            ->withCount('cadangan as jumlah_cadangan')
            ->withCount('ulasan as jumlah_ulasan')
            ->orderBy('jumlah_cadangan', 'desc')
            ->get();

        $namaFail = 'laporan_statistik_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $namaFail . '"',
        ];

        $callback = function () use ($peranti) {
            $file = fopen('php://output', 'w');

            // BOM supaya Excel papar aksara dengan betul
            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'Nama Peranti',
                'Jenama',
                'Kategori',
                'Harga (RM)',
                'Skor Purata',
                'Jumlah Cadangan',
                'Jumlah Ulasan',
                'Status',
            ]);

            foreach ($peranti as $p) {
                fputcsv($file, [
                    $p->nama,
                    $p->jenama,
                    $p->kategori->nama_kategori ?? '-',
                    number_format($p->harga, 2),
                    number_format($p->skor_purata ?? 0, 2),
                    $p->jumlah_cadangan,
                    $p->jumlah_ulasan,
                    $p->status ? 'Aktif' : 'Tidak Aktif',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
