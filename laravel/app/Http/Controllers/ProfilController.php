<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        return view('pengguna.profil');
    }

    public function kemaskini(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'emel' => 'required|email|unique:users,emel,' . Auth::id(),
        ], [
            'nama.required' => 'Sila masukkan nama.',
            'emel.required' => 'Sila masukkan emel.',
            'emel.unique'   => 'Emel ini sudah digunakan.',
        ]);

        Auth::user()->update([
            'nama' => $request->nama,
            'emel' => $request->emel,
        ]);

        return back()->with('berjaya', 'Profil berjaya dikemaskini!');
    }

    public function tukarKataLaluan(Request $request)
    {
        $request->validate([
            'kata_laluan_semasa' => 'required',
            'kata_laluan_baru'   => 'required|min:6|confirmed',
        ], [
            'kata_laluan_semasa.required' => 'Sila masukkan kata laluan semasa.',
            'kata_laluan_baru.required'   => 'Sila masukkan kata laluan baru.',
            'kata_laluan_baru.min'        => 'Kata laluan minimum 6 aksara.',
            'kata_laluan_baru.confirmed'  => 'Pengesahan kata laluan tidak sepadan.',
        ]);

        if (!Hash::check($request->kata_laluan_semasa, Auth::user()->kata_laluan)) {
            return back()->withErrors(['kata_laluan_semasa' => 'Kata laluan semasa tidak betul.']);
        }

        Auth::user()->update([
            'kata_laluan' => Hash::make($request->kata_laluan_baru),
        ]);

        return back()->with('berjaya', 'Kata laluan berjaya ditukar!');
    }
}
