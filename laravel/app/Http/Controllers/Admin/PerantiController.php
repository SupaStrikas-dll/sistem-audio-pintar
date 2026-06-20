<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerantiAudio;
use App\Models\Kategori;
use Illuminate\Http\Request;

class PerantiController extends Controller
{
    // =====================================================
    // SENARAI SEMUA PERANTI
    // =====================================================
    public function index(Request $request)
    {
        $query = PerantiAudio::with('kategori');

        if ($request->cari) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->cari . '%')
                  ->orWhere('jenama', 'like', '%' . $request->cari . '%');
            });
        }

        if ($request->kategori) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_kategori', $request->kategori);
            });
        }

        if ($request->status !== null && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $peranti = $query->latest()->paginate(10);

        return view('admin.peranti.senarai', compact('peranti'));
    }

    // =====================================================
    // FORM TAMBAH
    // =====================================================
    public function tambah()
    {
        $kategori = Kategori::all();
        return view('admin.peranti.form', compact('kategori'));
    }

    // =====================================================
    // SIMPAN PERANTI BARU
    // =====================================================
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

        if ($request->hasFile('imej')) {
            $namaFail = time() . '_' . $request->file('imej')->getClientOriginalName();
            $request->file('imej')->move(public_path('images/peranti'), $namaFail);
            $data['imej'] = 'images/peranti/' . $namaFail;
        }

        $data['julat_frekuensi'] = $request->julat_frekuensi;

        $nilaiFreq = [];
        for ($i = 0; $i < 10; $i++) {
            $nilai = $request->input('freq_' . $i);
            if ($nilai !== null && $nilai !== '') {
                $nilaiFreq[] = (float) $nilai;
            }
        }
        if (count($nilaiFreq) > 0) {
            $data['data_frekuensi'] = json_encode($nilaiFreq);
        }

        PerantiAudio::create($data);

        return redirect()->route('admin.peranti')->with('berjaya', 'Peranti audio berjaya ditambah!');
    }

    // =====================================================
    // FORM KEMASKINI
    // =====================================================
    public function kemaskini($id)
    {
        $peranti = PerantiAudio::with('kategori')->findOrFail($id);
        $kategori = Kategori::all();
        return view('admin.peranti.form', compact('peranti', 'kategori'));
    }

    // =====================================================
    // SIMPAN KEMASKINI
    // =====================================================
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
        ], [
            'nama.required'        => 'Sila masukkan nama peranti.',
            'jenama.required'      => 'Sila masukkan jenama.',
            'id_kategori.required' => 'Sila pilih kategori.',
            'harga.required'       => 'Sila masukkan harga.',
            'imej.image'           => 'Fail mesti berformat imej.',
            'imej.max'             => 'Saiz imej maksimum 2MB.',
        ]);

        $data = $request->only(['nama', 'jenama', 'id_kategori', 'harga', 'penerangan', 'status']);

        if ($request->hasFile('imej')) {
            if ($peranti->imej && file_exists(public_path($peranti->imej))) {
                unlink(public_path($peranti->imej));
            }
            $namaFail = time() . '_' . $request->file('imej')->getClientOriginalName();
            $request->file('imej')->move(public_path('images/peranti'), $namaFail);
            $data['imej'] = 'images/peranti/' . $namaFail;
        }

        $data['julat_frekuensi'] = $request->julat_frekuensi;

        $nilaiFreq = [];
        for ($i = 0; $i < 10; $i++) {
            $nilai = $request->input('freq_' . $i);
            if ($nilai !== null && $nilai !== '') {
                $nilaiFreq[] = (float) $nilai;
            }
        }
        if (count($nilaiFreq) > 0) {
            $data['data_frekuensi'] = json_encode($nilaiFreq);
        }

        $peranti->update($data);

        return redirect()->route('admin.peranti')->with('berjaya', 'Peranti audio berjaya dikemaskini!');
    }

    // =====================================================
    // PADAM PERANTI
    // =====================================================
    public function padam($id)
    {
        $peranti = PerantiAudio::findOrFail($id);

        if ($peranti->imej && file_exists(public_path($peranti->imej))) {
            unlink(public_path($peranti->imej));
        }

        $peranti->delete();

        return redirect()->route('admin.peranti')->with('berjaya', 'Peranti audio berjaya dipadam!');
    }

    // =====================================================
    // EKSPORT SENARAI PERANTI (CSV — boleh buka terus dalam Excel)
    // =====================================================
    public function export(Request $request)
    {
        $query = PerantiAudio::with('kategori');

        if ($request->kategori) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_kategori', $request->kategori);
            });
        }

        $peranti = $query->latest()->get();

        $namaFail = 'senarai_peranti_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $namaFail . '"',
        ];

        $callback = function () use ($peranti) {
            $file = fopen('php://output', 'w');

            // BOM supaya Excel papar aksara dengan betul
            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'Nama Peranti',
                'Jenama',
                'Kategori',
                'Harga (RM)',
                'Julat Frekuensi',
                'Skor Purata',
                'Status',
                'Tarikh Ditambah',
            ]);

            foreach ($peranti as $p) {
                fputcsv($file, [
                    $p->nama,
                    $p->jenama,
                    $p->kategori->nama_kategori ?? '-',
                    number_format($p->harga, 2),
                    $p->julat_frekuensi ?? '-',
                    number_format($p->skor_purata ?? 0, 2),
                    $p->status ? 'Aktif' : 'Tidak Aktif',
                    $p->created_at->format('d/m/Y'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
