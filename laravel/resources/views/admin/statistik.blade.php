<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex">

    <aside class="w-52 bg-[#1e1b4b] min-h-screen flex flex-col fixed left-0 top-0 z-40">
        <div class="px-4 py-5 border-b border-white/10">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-[#4f6ef7] rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round">
                        <line x1="4" y1="16" x2="4" y2="20" />
                        <line x1="9" y1="10" x2="9" y2="20" />
                        <line x1="14" y1="4" x2="14" y2="20" />
                        <line x1="19" y1="12" x2="19" y2="20" />
                    </svg>
                </div>
                <span class="text-sm font-bold text-white">Audio<span class="text-indigo-400">Pintar</span></span>
            </div>
        </div>
        <nav class="flex-1 py-4 px-3">
            <p class="text-xs font-semibold text-white/30 px-3 mb-2 uppercase tracking-wider">Utama</p>
            <a href="{{ route('admin.dashboard') }}" class="nav-item">Dashboard</a>
            <a href="{{ route('admin.pengguna') }}" class="nav-item">Pengguna</a>
            <a href="{{ route('admin.peranti') }}" class="nav-item">Peranti Audio</a>
            <a href="{{ route('admin.cadangan') }}" class="nav-item">Cadangan</a>
            <p class="text-xs font-semibold text-white/30 px-3 mt-5 mb-2 uppercase tracking-wider">Pengurusan</p>
            <a href="{{ route('admin.ulasan') }}" class="nav-item">Ulasan</a>
            <a href="{{ route('admin.statistik') }}" class="nav-item nav-active">Statistik</a>
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

    <main class="ml-52 flex-1 p-6">
        <div class="mb-6">
            <h1 class="text-lg font-bold text-gray-800">Statistik Sistem</h1>
            <p class="text-sm text-gray-400 mt-0.5">Ringkasan keseluruhan penggunaan sistem</p>
        </div>

        <div class="grid grid-cols-4 gap-4 mb-6">
            <div class="bg-white border border-gray-100 rounded-2xl p-5">
                <p class="text-xs font-semibold text-gray-400 mb-3">Jumlah Pengguna</p>
                <p class="text-3xl font-bold text-gray-800">{{ $jumlahPengguna ?? 0 }}</p>
                <p class="text-xs text-green-500 mt-1">Pengguna berdaftar</p>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-5">
                <p class="text-xs font-semibold text-gray-400 mb-3">Jumlah Peranti</p>
                <p class="text-3xl font-bold text-gray-800">{{ $jumlahPeranti ?? 0 }}</p>
                <p class="text-xs text-blue-500 mt-1">Peranti audio aktif</p>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-5">
                <p class="text-xs font-semibold text-gray-400 mb-3">Jumlah Cadangan</p>
                <p class="text-3xl font-bold text-gray-800">{{ $jumlahCadangan ?? 0 }}</p>
                <p class="text-xs text-purple-500 mt-1">Cadangan dijana</p>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-5">
                <p class="text-xs font-semibold text-gray-400 mb-3">Jumlah Ulasan</p>
                <p class="text-3xl font-bold text-gray-800">{{ $jumlahUlasan ?? 0 }}</p>
                <p class="text-xs text-yellow-500 mt-1">Ulasan ditulis</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div class="bg-white border border-gray-100 rounded-2xl p-5">
                <h2 class="text-sm font-bold text-gray-700 mb-4">Peranti Paling Popular</h2>
                @forelse($perantiPopular ?? [] as $p)
                <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">{{ $p->nama }}</p>
                        <p class="text-xs text-gray-400">{{ $p->jenama }}</p>
                    </div>
                    <span class="text-xs font-bold bg-blue-50 text-blue-600 px-3 py-1 rounded-full">
                        {{ $p->jumlah_cadangan }} cadangan
                    </span>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">Tiada data lagi.</p>
                @endforelse
            </div>

            <div class="bg-white border border-gray-100 rounded-2xl p-5">
                <h2 class="text-sm font-bold text-gray-700 mb-4">Kategori Paling Dicari</h2>
                @forelse($kategoriPopular ?? [] as $k)
                <div class="mb-4">
                    <div class="flex justify-between text-xs mb-1.5">
                        <span class="text-gray-500">{{ $k->nama_kategori }}</span>
                        <span class="font-semibold text-gray-700">{{ $k->jumlah }} carian</span>
                    </div>
                    <div class="bg-gray-100 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full"
                            style="width: {{ $k->jumlah > 0 ? min(($k->jumlah / max($kategoriPopular->max('jumlah'), 1)) * 100, 100) : 0 }}%">
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">Tiada data lagi.</p>
                @endforelse
            </div>
        </div>
    </main>
</body>

</html>