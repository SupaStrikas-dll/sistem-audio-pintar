<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($peranti) ? 'Kemaskini' : 'Tambah' }} Peranti Audio - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.55);
            margin-bottom: 2px;
            transition: all 0.15s;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.07);
            color: rgba(255, 255, 255, 0.85);
        }

        .nav-active {
            background: #4f6ef7 !important;
            color: white !important;
        }

        .freq-input::-webkit-inner-spin-button,
        .freq-input::-webkit-outer-spin-button {
            opacity: 1;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex">

    {{-- ==================== SIDEBAR ADMIN ==================== --}}
    <aside class="w-52 bg-[#1e1b4b] min-h-screen flex flex-col fixed left-0 top-0 z-40">
        <div class="px-4 py-5 border-b border-white/10">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-[#4f6ef7] rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24">
                        <path d="M12 3a9 9 0 0 0-9 9 9 9 0 0 0 9 9 9 9 0 0 0 9-9 9 9 0 0 0-9-9zm0 2a7 7 0 0 1 7 7 7 7 0 0 1-7 7A7 7 0 0 1 5 12 7 7 0 0 1 12 5zm0 2a5 5 0 0 0-5 5 5 5 0 0 0 5 5 5 5 0 0 0 5-5 5 5 0 0 0-5-5zm0 2a3 3 0 0 1 3 3 3 3 0 0 1-3 3 3 3 0 0 1-3-3 3 3 0 0 1 3-3z" />
                    </svg>
                </div>
                <span class="text-sm font-bold text-white">Audio<span class="text-indigo-400">Pintar</span></span>
            </div>
        </div>
        <nav class="flex-1 py-4 px-3">
            <p class="text-xs font-semibold text-white/30 px-3 mb-2 uppercase tracking-wider">Utama</p>
            <a href="{{ route('admin.dashboard') }}" class="nav-item">Dashboard</a>
            <a href="{{ route('admin.pengguna') }}" class="nav-item">Pengguna</a>
            <a href="{{ route('admin.peranti') }}" class="nav-item nav-active">Peranti Audio</a>
            <a href="{{ route('admin.cadangan') }}" class="nav-item">Cadangan</a>
            <p class="text-xs font-semibold text-white/30 px-3 mt-4 mb-2 uppercase tracking-wider">Pengurusan</p>
            <a href="{{ route('admin.ulasan') }}" class="nav-item">Ulasan</a>
            <a href="{{ route('admin.statistik') }}" class="nav-item">Statistik</a>
            <a href="{{ route('admin.tetapan') }}" class="nav-item">Tetapan</a>
            <form method="POST" action="{{ route('logout') }}" class="mt-2"
                onsubmit="return confirm('Adakah anda pasti mahu log keluar?')">
                @csrf
                <button type="submit" class="w-full text-left nav-item" style="color:#f87171;">Log Keluar</button>
            </form>
        </nav>
        <div class="px-4 py-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-[#4f6ef7] rounded-full flex items-center justify-center text-xs font-bold text-white uppercase">
                    {{ strtoupper(substr(optional(auth()->user())->nama ?? 'AD', 0, 2)) }}
                </div>
                <div>
                    <p class="text-xs font-semibold text-white">{{ optional(auth()->user())->nama ?? 'Admin' }}</p>
                    <p class="text-xs text-white/40">Pentadbir</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- ==================== KANDUNGAN UTAMA ==================== --}}
    <main class="ml-52 flex-1 p-6">

        {{-- Topbar --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-lg font-bold text-gray-800">
                    {{ isset($peranti) ? 'Kemaskini Peranti Audio' : 'Tambah Peranti Audio Baru' }}
                </h1>
                <p class="text-sm text-gray-400 mt-0.5">
                    {{ isset($peranti) ? 'Kemaskini maklumat peranti yang dipilih' : 'Isi maklumat peranti audio baru' }}
                </p>
            </div>
            <a href="{{ route('admin.peranti') }}"
                class="text-sm font-semibold text-gray-500 border border-gray-200 px-5 py-2.5 rounded-xl hover:bg-gray-50 transition">
                Kembali
            </a>
        </div>

        {{-- Mesej Ralat --}}
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl mb-5">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST"
            action="{{ isset($peranti) ? route('admin.peranti.update', $peranti->id) : route('admin.peranti.simpan') }}"
            enctype="multipart/form-data"
            id="mainForm"
            onsubmit="return prepareSubmit()">
            @csrf
            @if(isset($peranti))
            @method('PUT')
            @endif

            <div class="grid grid-cols-2 gap-5">

                {{-- ==================== KOLUM KIRI ==================== --}}
                <div class="space-y-5">

                    {{-- Maklumat Asas --}}
                    <div class="bg-white border border-gray-100 rounded-2xl p-6">
                        <h2 class="text-sm font-bold text-gray-700 mb-5">Maklumat Asas</h2>

                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Nama Peranti</label>
                            <input type="text" name="nama"
                                value="{{ old('nama', $peranti->nama ?? '') }}"
                                placeholder="Contoh: Sony WH-1000XM5"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Jenama</label>
                            <input type="text" name="jenama"
                                value="{{ old('jenama', $peranti->jenama ?? '') }}"
                                placeholder="Contoh: Sony"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                                required>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Kategori</label>
                                <select name="id_kategori"
                                    id="kategoriSelect"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                                    onchange="semakKategori()"
                                    required>
                                    <option value="">Pilih kategori</option>
                                    @foreach($kategori ?? [] as $k)
                                    <option value="{{ $k->id }}"
                                        data-nama="{{ $k->nama_kategori }}"
                                        {{ old('id_kategori', $peranti->id_kategori ?? '') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Harga (RM)</label>
                                <input type="number" name="harga"
                                    value="{{ old('harga', $peranti->harga ?? '') }}"
                                    placeholder="1299.00"
                                    step="0.01" min="0"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                                    required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Penerangan</label>
                            <textarea name="penerangan" rows="3"
                                placeholder="Tulis penerangan ringkas tentang peranti ini..."
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 resize-none">{{ old('penerangan', $peranti->penerangan ?? '') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Gambar Peranti</label>
                            @if(isset($peranti) && $peranti->imej)
                            <div class="mb-2">
                                <img src="{{ asset($peranti->imej) }}"
                                    alt="{{ $peranti->nama }}"
                                    class="w-20 h-20 object-cover rounded-xl border border-gray-200">
                            </div>
                            @endif
                            <input type="file" name="imej" accept="image/*"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                            <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Saiz maksimum: 2MB</p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Status</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="status" value="1"
                                        {{ old('status', $peranti->status ?? 1) == 1 ? 'checked' : '' }}
                                        class="accent-blue-600">
                                    <span class="text-sm text-gray-600">Aktif</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="status" value="0"
                                        {{ old('status', $peranti->status ?? 1) == 0 ? 'checked' : '' }}
                                        class="accent-blue-600">
                                    <span class="text-sm text-gray-600">Tidak Aktif</span>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- ==================== KOLUM KANAN ==================== --}}
                <div class="space-y-5">

                    {{-- Graf Frekuensi — hanya untuk Fon Telinga & Earphone --}}
                    <div id="bahagianFrekuensi" class="bg-white border border-gray-100 rounded-2xl p-6 {{ !isset($peranti) || !in_array($peranti->kategori->nama_kategori ?? '', ['Fon Telinga', 'Earphone']) ? 'hidden' : '' }}">

                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-sm font-bold text-gray-700">Tindak Balas Frekuensi</h2>
                            <span class="text-xs bg-blue-50 text-blue-600 px-3 py-1 rounded-full font-semibold">
                                Fon Telinga / Earphone sahaja
                            </span>
                        </div>
                        <p class="text-xs text-gray-400 mb-5">Isi nilai desibel (dB) untuk setiap frekuensi. Nilai biasa antara 60 - 100 dB.</p>

                        {{-- Julat Frekuensi --}}
                        <div class="mb-5">
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Julat Frekuensi</label>
                            <input type="text" name="julat_frekuensi"
                                value="{{ old('julat_frekuensi', $peranti->julat_frekuensi ?? '20Hz - 20,000Hz') }}"
                                placeholder="Contoh: 20Hz - 20,000Hz"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>

                        {{-- Input 10 nilai dB --}}
                        @php
                        $freqLabels = ['20Hz', '50Hz', '100Hz', '200Hz', '500Hz', '1kHz', '2kHz', '5kHz', '10kHz', '20kHz'];
                        $existingFreq = [];
                        if(isset($peranti) && $peranti->data_frekuensi) {
                        $existingFreq = json_decode($peranti->data_frekuensi, true) ?? [];
                        }
                        @endphp

                        <label class="block text-xs font-semibold text-gray-500 mb-3">Nilai dB Pada Setiap Frekuensi</label>
                        <div class="grid grid-cols-5 gap-3 mb-5">
                            @foreach($freqLabels as $index => $label)
                            <div class="text-center">
                                <label class="block text-xs text-gray-400 mb-1">{{ $label }}</label>
                                <input
                                    type="number"
                                    name="freq_{{ $index }}"
                                    id="freq_{{ $index }}"
                                    value="{{ old('freq_'.$index, $existingFreq[$index] ?? '') }}"
                                    min="-50" max="120" step="0.1"
                                    placeholder="dB"
                                    oninput="kemasBariGraf()"
                                    class="freq-input w-full bg-gray-50 border border-gray-200 rounded-lg px-2 py-2 text-sm text-center focus:outline-none focus:ring-2 focus:ring-blue-200">
                            </div>
                            @endforeach
                        </div>

                        {{-- Preview Graf --}}
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-gray-500 mb-3">Pratonton Graf</p>
                            <div class="relative h-40">
                                <canvas id="previewGraf"></canvas>
                            </div>
                        </div>

                        {{-- Hidden input untuk hantar data --}}
                        <input type="hidden" name="data_frekuensi" id="dataFrekuensiHidden">

                    </div>

                    {{-- Nota kalau bukan Fon Telinga/Earphone --}}
                    <div id="notaFrekuensi" class="{{ isset($peranti) && in_array($peranti->kategori->nama_kategori ?? '', ['Fon Telinga', 'Earphone']) ? 'hidden' : '' }} bg-gray-50 border border-gray-100 rounded-2xl p-6">
                        <p class="text-sm text-gray-400 text-center">
                            Graf tindak balas frekuensi hanya tersedia untuk kategori<br>
                            <span class="font-semibold text-gray-600">Fon Telinga</span> dan <span class="font-semibold text-gray-600">Earphone</span>.
                        </p>
                    </div>

                </div>
            </div>

            {{-- Butang Submit --}}
            <div class="flex gap-3 mt-5">
                <button type="submit"
                    class="bg-[#4f6ef7] hover:bg-blue-700 text-white text-sm font-semibold px-6 py-3 rounded-xl transition">
                    {{ isset($peranti) ? 'Simpan Perubahan' : 'Tambah Peranti' }}
                </button>
                <a href="{{ route('admin.peranti') }}"
                    class="text-sm font-semibold text-gray-500 border border-gray-200 px-6 py-3 rounded-xl hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>

        </form>
    </main>

</body>

<script>
    const freqLabels = ['20Hz', '50Hz', '100Hz', '200Hz', '500Hz', '1kHz', '2kHz', '5kHz', '10kHz', '20kHz'];

    function semakKategori() {
        const select = document.getElementById('kategoriSelect');
        const option = select.options[select.selectedIndex];
        const nama = option.dataset.nama || '';
        const bahagian = document.getElementById('bahagianFrekuensi');
        const nota = document.getElementById('notaFrekuensi');

        if (nama === 'Fon Telinga' || nama === 'Earphone') {
            bahagian.classList.remove('hidden');
            nota.classList.add('hidden');
        } else {
            bahagian.classList.add('hidden');
            nota.classList.remove('hidden');
        }
    }

    let previewChart = null;

    function kemasBariGraf() {
        const nilai = [];
        for (let i = 0; i < 10; i++) {
            const input = document.getElementById('freq_' + i);
            nilai.push(input && input.value !== '' ? parseFloat(input.value) : null);
        }

        const ctx = document.getElementById('previewGraf').getContext('2d');

        if (previewChart) {
            previewChart.data.datasets[0].data = nilai;
            previewChart.update();
        } else {
            previewChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: freqLabels,
                    datasets: [{
                        data: nilai,
                        borderColor: '#4f6ef7',
                        backgroundColor: 'rgba(79,110,247,0.08)',
                        borderWidth: 2,
                        pointBackgroundColor: '#4f6ef7',
                        pointRadius: 3,
                        tension: 0.4,
                        fill: true,
                        spanGaps: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                font: {
                                    size: 10
                                },
                                color: '#9ca3af'
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.04)'
                            }
                        },
                        y: {
                            min: -60,
                            max: 120,
                            ticks: {
                                font: {
                                    size: 10
                                },
                                color: '#9ca3af',
                                callback: v => v + ' dB'
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.04)'
                            }
                        }
                    }
                }
            });
        }

        // Kemaskini hidden input setiap kali nilai berubah
        kemaskiniHidden();
    }

    function kemaskiniHidden() {
        const nilai = [];
        for (let i = 0; i < 10; i++) {
            const input = document.getElementById('freq_' + i);
            if (input && input.value !== '') {
                nilai.push(parseFloat(input.value));
            }
        }
        if (nilai.length > 0) {
            document.getElementById('dataFrekuensiHidden').value = JSON.stringify(nilai);
        }
    }

    function prepareSubmit() {
        kemaskiniHidden();
        return true;
    }

    window.onload = function() {
        semakKategori();

        // Kemaskini hidden input dengan data sedia ada
        kemaskiniHidden();

        const adaNilai = document.getElementById('freq_0').value !== '';
        if (adaNilai) kemasBariGraf();
    };
</script>

</html>