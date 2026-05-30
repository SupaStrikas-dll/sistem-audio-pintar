<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Cadangan Audio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .nav-active { background: #eef0fe; color: #4f6ef7; border-left: 3px solid #4f6ef7; font-weight: 600; }
        .card-hover { transition: transform 0.2s ease; }
        .card-hover:hover { transform: translateY(-2px); }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex">

    {{-- ==================== SIDEBAR ==================== --}}
    <aside class="w-56 bg-white border-r border-gray-100 min-h-screen flex flex-col fixed left-0 top-0 z-40">

        {{-- Logo --}}
        <div class="px-5 py-5 border-b border-gray-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24"><path d="M12 3a9 9 0 0 0-9 9 9 9 0 0 0 9 9 9 9 0 0 0 9-9 9 9 0 0 0-9-9zm0 2a7 7 0 0 1 7 7 7 7 0 0 1-7 7A7 7 0 0 1 5 12 7 7 0 0 1 12 5zm0 2a5 5 0 0 0-5 5 5 5 0 0 0 5 5 5 5 0 0 0 5-5 5 5 0 0 0-5-5zm0 2a3 3 0 0 1 3 3 3 3 0 0 1-3 3 3 3 0 0 1-3-3 3 3 0 0 1 3-3z"/></svg>
                </div>
                <span class="text-sm font-bold">Audio<span class="text-blue-600">Pintar</span></span>
            </div>
        </div>

        {{-- Nav Menu --}}
        <nav class="flex-1 py-4 px-3">
            <p class="text-xs font-semibold text-gray-400 px-3 mb-2 uppercase tracking-wider">Menu Utama</p>

            <a href="{{ route('pengguna.dashboard') }}"
                 class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm mb-1 nav-active">
                Dashboard
            </a>

<a href="{{ route('keutamaan.borang') }}"
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">
   Cadangan Baru
</a>

<a href="{{ route('sejarah.index') }}"
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">
   Sejarah Cadangan
</a>

<a href="{{ route('ulasan.index') }}"
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">
   Ulasan Saya
</a>

<p class="text-xs font-semibold text-gray-400 px-3 mt-5 mb-2 uppercase tracking-wider">Akaun</p>

<a href="{{ route('profil.index') }}"
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">
   Profil Saya
</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-red-400 hover:bg-red-50 transition text-left">
                    Log Keluar
                </button>
            </form>
        </nav>

        {{-- Info Pengguna --}}
        <div class="px-4 py-4 border-t border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold uppercase">
                    {{ strtoupper(substr(optional(auth()->user())->nama ?? 'TT', 0, 2)) }}
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-700">{{ optional(auth()->user())->nama ?? 'Tetamu' }}</p>
                    <p class="text-xs text-gray-400">Pengguna</p>
                </div>
            </div>
        </div>

    </aside>

    {{-- ==================== KANDUNGAN UTAMA ==================== --}}
    <main class="ml-56 flex-1 p-6">

        {{-- Topbar --}}
        <div class="flex items-center justify-between mb-7">
            <div>
                <h1 class="text-lg font-bold text-gray-800">
                    Selamat Datang, {{ optional(auth()->user())->nama ?? 'Tetamu' }}! 
                </h1>
                <p class="text-sm text-gray-400 mt-0.5">
                    {{ now()->locale('ms')->isoFormat('dddd, D MMMM YYYY') }}
                </p>
            </div>
            <div class="flex items-center gap-3">

                <div class="w-9 h-9 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold uppercase">
                  {{ strtoupper(substr(optional(auth()->user())->nama ?? 'TT', 0, 2)) }}
                </div>
            </div>
        </div>

        {{-- ==================== KAD STATISTIK ==================== --}}
        <div class="grid grid-cols-3 gap-4 mb-6">

            <div class="bg-white border border-gray-100 rounded-2xl p-5 card-hover">
                <p class="text-2xl font-bold text-gray-800">{{ $jumlahCadangan ?? 0 }}</p>
                <p class="text-xs text-gray-400 mt-1">Jumlah Cadangan</p>
            </div>

            <div class="bg-white border border-gray-100 rounded-2xl p-5 card-hover">
                <p class="text-2xl font-bold text-gray-800">{{ $jumlahUlasan ?? 0 }}</p>
                <p class="text-xs text-gray-400 mt-1">Ulasan Ditulis</p>
            </div>

            <div class="bg-white border border-gray-100 rounded-2xl p-5 card-hover">
                <p class="text-2xl font-bold text-gray-800">{{ $jumlahPerantiDilihat ?? 0 }}</p>
                <p class="text-xs text-gray-400 mt-1">Peranti Dilihat</p>
            </div>

        </div>

        {{-- ==================== GRID UTAMA ==================== --}}
        <div class="grid grid-cols-2 gap-5">

            {{-- Kad Cadangan Terkini --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-gray-700 flex items-center gap-2">
                         Cadangan Terkini
                    </h2>
                    <a href="#" class="text-xs text-blue-500 hover:underline">Lihat Semua</a>
                </div>

                @forelse($cadanganTerkini ?? [] as $cadangan)
                    <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">{{ $cadangan->peranti->nama_peranti }}</p>
                            <p class="text-xs text-gray-400">{{ $cadangan->peranti->kategori }} • RM {{ number_format($cadangan->peranti->harga, 2) }}</p>
                        </div>
                        <span class="text-xs font-semibold bg-blue-50 text-blue-600 px-3 py-1 rounded-full">
                            {{ $cadangan->skor_padanan }}%
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-sm text-gray-400">Belum ada cadangan lagi.</p>
                        <p class="text-xs text-gray-300 mt-1">Mulakan dengan isi borang keutamaan</p>
                    </div>
                @endforelse

                <a href="{{ route('keutamaan.borang') }}"
                   class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 rounded-xl flex items-center justify-center gap-2 transition">
                     Dapatkan Cadangan Baru
                </a>
            </div>

            {{-- Kad Profil & Sejarah --}}
            <div class="flex flex-col gap-5">

                {{-- Profil Ringkas --}}
                <div class="bg-white border border-gray-100 rounded-2xl p-5">
                    <h2 class="text-sm font-bold text-gray-700 mb-4 flex items-center gap-2">
                         Profil Saya
                    </h2>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-2 border-b border-gray-50">
                            <span class="text-xs text-gray-400">Nama</span>
                            <span class="text-xs font-semibold text-gray-700">{{ optional(auth()->user())->nama ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-50">
                            <span class="text-xs text-gray-400">Emel</span>
                            <span class="text-xs font-semibold text-gray-700">{{ optional(auth()->user())->email ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-50">
                            <span class="text-xs text-gray-400">Ahli Sejak</span>
                            <span class="text-xs font-semibold text-gray-700">{{ optional(auth()->user())->created_at?->format('M Y') ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-xs text-gray-400">Status</span>
                            <span class="text-xs font-semibold bg-green-50 text-green-600 px-3 py-1 rounded-full">Aktif</span>
                        </div>
                    </div>
                    <a href="#"
                       class="mt-4 w-full border border-blue-200 text-blue-600 text-sm font-semibold py-2.5 rounded-xl flex items-center justify-center gap-2 hover:bg-blue-50 transition">
                         Kemaskini Profil
                    </a>
                </div>

                {{-- Sejarah Ringkas --}}
                <div class="bg-white border border-gray-100 rounded-2xl p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-sm font-bold text-gray-700 flex items-center gap-2">
                             Sejarah Terkini
                        </h2>
                        <a href="#" class="text-xs text-blue-500 hover:underline">Lihat Semua</a>
                    </div>

                    @forelse($sejarahTerkini ?? [] as $sejarah)
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50 last:border-0">
                            <div>
                                <p class="text-xs font-semibold text-gray-700">{{ $sejarah->keutamaan->jenis_peranti }}</p>
                                <p class="text-xs text-gray-400">{{ $sejarah->tarikh_cadangan->diffForHumans() }}</p>
                            </div>
                            <span class="text-xs bg-purple-50 text-purple-600 px-2.5 py-1 rounded-full font-semibold">Selesai</span>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">Tiada sejarah lagi.</p>
                    @endforelse

                </div>

            </div>
        </div>

    </main>

</body>
</html>