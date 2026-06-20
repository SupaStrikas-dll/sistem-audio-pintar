<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cadangan;

class CadanganController extends Controller
{
    public function index()
    {
        $cadangan = Cadangan::with('pilihan.pengguna', 'peranti')
            ->latest()->paginate(10);

        return view('admin.cadangan', compact('cadangan'));
    }
}
