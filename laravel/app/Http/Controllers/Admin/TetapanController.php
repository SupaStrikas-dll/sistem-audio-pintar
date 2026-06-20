<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TetapanController extends Controller
{
    public function index()
    {
        return view('admin.tetapan');
    }

    public function kemaskini(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'emel' => 'required|email|unique:users,emel,' . Auth::id(),
        ]);

        Auth::user()->update([
            'nama' => $request->nama,
            'emel' => $request->emel,
        ]);

        return back()->with('berjaya', 'Maklumat berjaya dikemaskini!');
    }

    public function kataLaluan(Request $request)
    {
        $request->validate([
            'kata_laluan_semasa' => 'required',
            'kata_laluan_baru'   => 'required|min:6|confirmed',
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
