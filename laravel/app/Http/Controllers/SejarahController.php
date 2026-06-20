<?php

namespace App\Http\Controllers;

use App\Models\PilihanPengguna;
use Illuminate\Support\Facades\Auth;

class SejarahController extends Controller
{
    public function index()
    {
        $sejarah = PilihanPengguna::with('cadangan.peranti.kategori')
            ->where('id_pengguna', Auth::id())
            ->latest()
            ->get();

        return view('pengguna.sejarah', compact('sejarah'));
    }
}
