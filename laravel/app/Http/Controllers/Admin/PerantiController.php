<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerantiAudio;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerantiController extends Controller
{
    // Senarai semua peranti
    public function index(Request $request)
    {
        $query = PerantiAudio::with('kategori');

        // Carian
        if ($request->cari) {
            $query->where('nama', 'like', '%' . $request->cari . '%')
                  ->orWhere('jenama', 'like', '%' . $request->cari . '%');
        }

        // Filter kategori
        if ($request->kategori) {
            $query->whereHas('kategori', function($q) use ($request) {
                $q->where('nama_kategori', $request->kategori);
            });
        }

        // Filter status
        if ($request->status !== null && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $peranti = $query->latest()->paginate(10);

        return view('admin.peranti.senarai', compact('peranti'));
    }

    // Form tambah
    public function tambah()
    {
        $kategori = Kategori::all();
        return view('admin.peranti.form', compact('kategori'));
    }

    // Simpan peranti baru
    public function simpan(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'jenama'      => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'harga'       => 'required|numeric|min:0',
            'penerangan'  => 'nullable|string',
            'imej'        => 'nullable|image|max:2048',
            'status'      => 'required|in:0,1',
        ], [
            'nama.required'        => 'Sila masukkan nama peranti.',
            'jenama.required'      => 'Sila masukkan jenama.',
            'id_kategori.required' => 'Sila pilih kategori.',
            'harga.required'       => 'Sila masukkan harga.',
            'imej.image'           => 'Fail mesti berformat imej.',
            'imej.max'             => 'Saiz imej maksimum 2MB.',
        ]);

        $data = $request->only(['nama', 'jenama', 'id_kategori', 'harga', 'penerangan', 'status']);

        // Upload imej
        if ($request->hasFile('imej')) {
            $data['imej'] = $request->file('imej')->store('peranti', 'public');
        }

        PerantiAudio::create($data);

        return redirect()->route('admin.peranti')->with('berjaya', 'Peranti audio berjaya ditambah!');
    }

    // Form kemaskini
    public function kemaskini($id)
    {
        $peranti = PerantiAudio::findOrFail($id);
        $kategori = Kategori::all();
        return view('admin.peranti.form', compact('peranti', 'kategori'));
    }

    // Simpan kemaskini
    public function update(Request $request, $id)
    {
        $peranti = PerantiAudio::findOrFail($id);

        $request->validate([
            'nama'        => 'required|string|max:255',
            'jenama'      => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'harga'       => 'required|numeric|min:0',
            'penerangan'  => 'nullable|string',
            'imej'        => 'nullable|image|max:2048',
            'status'      => 'required|in:0,1',
        ]);

        $data = $request->only(['nama', 'jenama', 'id_kategori', 'harga', 'penerangan', 'status']);

        // Upload imej baru
        if ($request->hasFile('imej')) {
            // Padam imej lama
            if ($peranti->imej) {
                Storage::disk('public')->delete($peranti->imej);
            }
            $data['imej'] = $request->file('imej')->store('peranti', 'public');
        }

        $peranti->update($data);

        return redirect()->route('admin.peranti')->with('berjaya', 'Peranti audio berjaya dikemaskini!');
    }

    // Padam peranti
    public function padam($id)
    {
        $peranti = PerantiAudio::findOrFail($id);

        // Padam imej
        if ($peranti->imej) {
            Storage::disk('public')->delete($peranti->imej);
        }

        $peranti->delete();

        return redirect()->route('admin.peranti')->with('berjaya', 'Peranti audio berjaya dipadam!');
    }
}