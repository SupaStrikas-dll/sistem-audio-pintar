<?php

namespace App\Http\Controllers;

use App\Models\PerantiAudio;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function index()
    {
        $ulasan = Ulasan::with('peranti', 'pengguna')->latest()->get();
        $senaraiPeranti = PerantiAudio::with('kategori')->get();

        return view('pengguna.ulasan', compact('ulasan', 'senaraiPeranti'));
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'id_peranti' => 'required|exists:peranti_audio,id',
            'penilaian'  => 'required|integer|min:1|max:5',
            'komen'      => 'nullable|string|max:500',
        ], [
            'id_peranti.required' => 'Sila pilih peranti.',
            'penilaian.required'  => 'Sila beri penilaian bintang.',
            'penilaian.min'       => 'Penilaian minimum 1 bintang.',
        ]);

        Ulasan::create([
            'id_pengguna' => Auth::id(),
            'id_peranti'  => $request->id_peranti,
            'penilaian'   => $request->penilaian,
            'komen'       => $request->komen,
            'tarikh'      => now(),
        ]);

        $this->kemaskiniSkorPurata($request->id_peranti);

        return back()->with('berjaya', 'Ulasan berjaya dihantar!');
    }

    public function padam($id)
    {
        $ulasan = Ulasan::where('id', $id)
            ->where('id_pengguna', Auth::id())
            ->firstOrFail();

        $idPeranti = $ulasan->id_peranti;
        $ulasan->delete();

        $this->kemaskiniSkorPurata($idPeranti);

        return back()->with('berjaya', 'Ulasan berjaya dipadam!');
    }

    // Kira semula purata skor peranti selepas ulasan ditambah/dipadam
    private function kemaskiniSkorPurata($idPeranti)
    {
        $peranti = PerantiAudio::find($idPeranti);
        if ($peranti) {
            $skorPurata = Ulasan::where('id_peranti', $idPeranti)->avg('penilaian');
            $peranti->update(['skor_purata' => round($skorPurata ?? 0, 2)]);
        }
    }
}
