<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->cari) {
            $query->where('nama', 'like', '%' . $request->cari . '%')
                  ->orWhere('emel', 'like', '%' . $request->cari . '%');
        }

        $pengguna = $query->latest()->paginate(10);

        return view('admin.pengguna', compact('pengguna'));
    }

    public function padam($id)
    {
        User::findOrFail($id)->delete();

        return back()->with('berjaya', 'Pengguna berjaya dipadam!');
    }
}
