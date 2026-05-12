<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Papar halaman login
    public function halamanLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function prosesLogin(Request $request)
    {
        $request->validate([
            'emel'        => 'required|email',
            'kata_laluan' => 'required|min:6',
        ], [
            'emel.required'        => 'Sila masukkan emel.',
            'emel.email'           => 'Format emel tidak sah.',
            'kata_laluan.required' => 'Sila masukkan kata laluan.',
            'kata_laluan.min'      => 'Kata laluan minimum 6 aksara.',
        ]);

        // Cari pengguna ikut emel
        $pengguna = User::where('emel', $request->emel)->first();

        // Semak kata laluan
        if ($pengguna && Hash::check($request->kata_laluan, $pengguna->kata_laluan)) {
            Auth::login($pengguna);
            $request->session()->regenerate();

            // Redirect ikut peranan
            if ($pengguna->peranan === 'pentadbir') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('pengguna.dashboard');
        }

        return back()->withErrors([
            'emel' => 'Emel atau kata laluan tidak sepadan.',
        ]);
    }

    // Papar halaman daftar
    public function halamanDaftar()
    {
        return view('auth.register');
    }

    // Proses daftar
    public function prosesDaftar(Request $request)
    {
        $request->validate([
            'nama'                  => 'required|string|max:255',
            'emel'                  => 'required|email|unique:users,emel',
            'kata_laluan'           => 'required|min:6|confirmed',
        ], [
            'nama.required'                  => 'Sila masukkan nama.',
            'emel.required'                  => 'Sila masukkan emel.',
            'emel.unique'                    => 'Emel ini sudah didaftarkan.',
            'kata_laluan.required'           => 'Sila masukkan kata laluan.',
            'kata_laluan.min'                => 'Kata laluan minimum 6 aksara.',
            'kata_laluan.confirmed'          => 'Pengesahan kata laluan tidak sepadan.',
        ]);

        User::create([
            'nama'        => $request->nama,
            'emel'        => $request->emel,
            'kata_laluan' => Hash::make($request->kata_laluan),
            'peranan'     => 'pengguna',
        ]);

        return redirect()->route('login')->with('berjaya', 'Akaun berjaya didaftarkan! Sila log masuk.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}