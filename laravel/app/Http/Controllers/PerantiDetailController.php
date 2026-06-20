<?php

namespace App\Http\Controllers;

use App\Models\PerantiAudio;

class PerantiDetailController extends Controller
{
    public function index($id)
    {
        $peranti = PerantiAudio::with('kategori', 'ulasan.pengguna')->findOrFail($id);

        return view('pengguna.detail_peranti', compact('peranti'));
    }
}
