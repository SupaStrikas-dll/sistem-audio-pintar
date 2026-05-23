<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($peranti) ? 'Kemaskini' : 'Tambah' }} Peranti Audio - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .nav-active {
            background: #4f6ef7 !important;
            color: white !important;
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
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
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

        {{-- Borang --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6 max-w-2xl">
            <form method="POST"
                action="{{ isset($peranti) ? route('admin.peranti.update', $peranti->id) : route('admin.peranti.simpan') }}"
                enctype="multipart/form-data">
                @csrf
                @if(isset($peranti))
                @method('PUT')
                @endif

                {{-- Nama Peranti --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-600 mb-1.5">Nama Peranti</label>
                    <input
                        type="text"
                        name="nama"
                        value="{{ old('nama', $peranti->nama ?? '') }}"
                        placeholder="Contoh: Sony WH-1000XM5"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                        required>
                </div>

                {{-- Jenama --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-600 mb-1.5">Jenama</label>
                    <input
                        type="text"
                        name="jenama"
                        value="{{ old('jenama', $peranti->jenama ?? '') }}"
                        placeholder="Contoh: Sony"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                        required>
                </div>

                {{-- Kategori & Harga --}}
                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1.5">Kategori</label>
                        <select name="id_kategori"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                            required>
                            <option value="">Pilih kategori</option>
                            @foreach($kategori ?? [] as $k)
                            <option value="{{ $k->id }}"
                                {{ old('id_kategori', $peranti->id_kategori ?? '') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1.5">Harga (RM)</label>
                        <input
                            type="number"
                            name="harga"
                            value="{{ old('harga', $peranti->harga ?? '') }}"
                            placeholder="Contoh: 1299.00"
                            step="0.01"
                            min="0"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                            required>
                    </div>
                </div>

                {{-- Penerangan --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-600 mb-1.5">Penerangan</label>
                    <textarea
                        name="penerangan"
                        rows="4"
                        placeholder="Tulis penerangan ringkas tentang peranti ini..."
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 resize-none">{{ old('penerangan', $peranti->penerangan ?? '') }}</textarea>
                </div>

                {{-- Imej --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-600 mb-1.5">Imej Peranti</label>
                    @if(isset($peranti) && $peranti->imej)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $peranti->imej) }}"
                            alt="{{ $peranti->nama }}"
                            class="w-24 h-24 object-cover rounded-xl border border-gray-200">
                    </div>
                    @endif
                    <input
                        type="file"
                        name="imej"
                        accept="image/*"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Saiz maksimum: 2MB</p>
                </div>

                {{-- Status --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-600 mb-1.5">Status</label>
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

                {{-- Butang --}}
                <div class="flex gap-3">
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
        </div>

    </main>

</body>

</html>