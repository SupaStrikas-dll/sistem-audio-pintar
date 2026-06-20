<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use App\Models\PerantiAudio;

class UlasanController extends Controller
{
    public function index()
    {
        $ulasan = Ulasan::with('pengguna', 'peranti')->latest()->paginate(10);

        return view('admin.ulasan', compact('ulasan'));
    }

    public function padam($id)
    {
        $ulasan = Ulasan::findOrFail($id);
        $idPeranti = $ulasan->id_peranti;
        $ulasan->delete();

        // Kemaskini semula skor purata peranti
        $peranti = PerantiAudio::find($idPeranti);
        if ($peranti) {
            $skorPurata = Ulasan::where('id_peranti', $idPeranti)->avg('penilaian');
            $peranti->update(['skor_purata' => round($skorPurata ?? 0, 2)]);
        }

        return back()->with('berjaya', 'Ulasan berjaya dipadam!');
    }
}
