<?php

namespace App\Http\Controllers;

use App\Models\Cadangan;
use App\Models\PerantiAudio;
use App\Models\PilihanPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CadanganController extends Controller
{
    // =====================================================
    // PAPAR BORANG KEUTAMAAN
    // =====================================================
    public function borang()
    {
        return view('pengguna.borang_keutamaan');
    }

    // =====================================================
    // SIMPAN PILIHAN & JANA CADANGAN
    // =====================================================
    public function simpanPilihan(Request $request)
    {
        $request->validate([
            'jenis'    => 'required|string',
            'bajet'    => 'required|numeric|min:0',
            'kegunaan' => 'required|string',
        ], [
            'jenis.required'    => 'Sila pilih jenis peranti.',
            'bajet.required'    => 'Sila tetapkan bajet.',
            'kegunaan.required' => 'Sila pilih kegunaan utama.',
        ]);

        $pilihan = PilihanPengguna::create([
            'id_pengguna' => Auth::id(),
            'jenis'       => $request->jenis,
            'bajet'       => $request->bajet,
            'kegunaan'    => $request->kegunaan,
        ]);

        $this->janaCadangan($pilihan);

        return redirect()->route('cadangan.hasil', $pilihan->id);
    }

    // =====================================================
    // LOGIC UTAMA — JANA CADANGAN
    // =====================================================
    private function janaCadangan(PilihanPengguna $pilihan)
    {
        $semuaPeranti = PerantiAudio::with('kategori')
            ->where('status', 1)
            ->get();

        Cadangan::where('id_pilihan', $pilihan->id)->delete();

        $cadanganList = [];

        foreach ($semuaPeranti as $peranti) {
            $skor = $this->kiraSkor($pilihan, $peranti);

            if ($skor > 0) {
                $cadanganList[] = [
                    'id_pilihan'   => $pilihan->id,
                    'id_peranti'   => $peranti->id,
                    'skor_padanan' => $skor,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ];
            }
        }

        if (!empty($cadanganList)) {
            Cadangan::insert($cadanganList);
        }
    }

    // =====================================================
    // KIRA SKOR PADANAN (0 - 100)
    // =====================================================
    private function kiraSkor(PilihanPengguna $pilihan, PerantiAudio $peranti): int
    {
        $skor = 0;
        $namaKategori = $peranti->kategori->nama_kategori ?? '';

        // ---- 1. JENIS PERANTI (40 mata) ----
        if (strtolower($pilihan->jenis) === strtolower($namaKategori)) {
            $skor += 40;
        } else {
            return 0;
        }

        // ---- 2. BAJET (30 mata) ----
        if ($peranti->harga <= $pilihan->bajet) {
            $skor += 30;
        } elseif ($peranti->harga <= ($pilihan->bajet * 1.2)) {
            $skor += 15;
        } else {
            // Harga jauh melebihi bajet (lebih 20%) — singkirkan terus
            return 0;
        }

        // ---- 3. KEGUNAAN (20 mata) ----
        $pemetaanKegunaan = [
            'Gaming' => ['Gaming', 'Hiburan'],
            'Muzik'  => ['Muzik', 'Hiburan', 'Studio'],
            'Kerja'  => ['Kerja', 'Mesyuarat', 'Perniagaan'],
            'Studio' => ['Studio', 'Rakaman', 'Muzik'],
        ];

        $kegunaanBerkaitan = $pemetaanKegunaan[$pilihan->kegunaan] ?? [$pilihan->kegunaan];

        foreach ($kegunaanBerkaitan as $k) {
            if (stripos($peranti->penerangan ?? '', $k) !== false ||
                stripos($peranti->nama ?? '', $k) !== false) {
                $skor += 20;
                break;
            }
        }

        if ($skor < 60) {
            $skor += 10;
        }

        return min($skor, 100);
    }

    // =====================================================
    // PAPAR HASIL CADANGAN
    // =====================================================
    public function hasilCadangan($id)
    {
        $pilihan = PilihanPengguna::where('id', $id)
            ->where('id_pengguna', Auth::id())
            ->firstOrFail();

        $cadangan = Cadangan::with('peranti.kategori')
            ->where('id_pilihan', $pilihan->id)
            ->orderBy('skor_padanan', 'desc')
            ->get();

        return view('pengguna.cadangan', compact('cadangan', 'pilihan'));
    }
}
