<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Cadangan - Sistem Cadangan Audio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .card-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .card-hover:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(79,110,247,0.1); }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex">

    {{-- ==================== SIDEBAR ==================== --}}
    <aside class="w-56 bg-white border-r border-gray-100 min-h-screen flex flex-col fixed left-0 top-0 z-40">
        <div class="px-5 py-5 border-b border-gray-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24"><path d="M12 3a9 9 0 0 0-9 9 9 9 0 0 0 9 9 9 9 0 0 0 9-9 9 9 0 0 0-9-9zm0 2a7 7 0 0 1 7 7 7 7 0 0 1-7 7A7 7 0 0 1 5 12 7 7 0 0 1 12 5zm0 2a5 5 0 0 0-5 5 5 5 0 0 0 5 5 5 5 0 0 0 5-5 5 5 0 0 0-5-5zm0 2a3 3 0 0 1 3 3 3 3 0 0 1-3 3 3 3 0 0 1-3-3 3 3 0 0 1 3-3z"/></svg>
                </div>
                <span class="text-sm font-bold">Audio<span class="text-blue-600">Pintar</span></span>
            </div>
        </div>
        <nav class="flex-1 py-4 px-3">
            <p class="text-xs font-semibold text-gray-400 px-3 mb-2 uppercase tracking-wider">Menu Utama</p>
            <a href="{{ route('pengguna.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">📊 Dashboard</a>
            <a href="{{ route('keutamaan.borang') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm mb-1" style="background:#eef0fe;color:#4f6ef7;font-weight:600;border-left:3px solid #4f6ef7;">✨ Cadangan Baru</a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">🕐 Sejarah Cadangan</a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">⭐ Ulasan Saya</a>
            <p class="text-xs font-semibold text-gray-400 px-3 mt-5 mb-2 uppercase tracking-wider">Akaun</p>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">👤 Profil Saya</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-red-400 hover:bg-red-50 transition text-left">🚪 Log Keluar</button>
            </form>
        </nav>
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
        <div class="flex items-center justify-between mb-5">
            <div>
                <h1 class="text-lg font-bold text-gray-800">✨ Hasil Cadangan Peranti Audio</h1>
                <p class="text-sm text-gray-400 mt-0.5">
                    Berdasarkan keutamaan anda —
                    <span class="text-blue-600 font-semibold">{{ $pilihan->jenis ?? '-' }}</span> •
                    <span class="text-blue-600 font-semibold">RM {{ number_format($pilihan->bajet ?? 0, 0) }}</span> •
                    <span class="text-blue-600 font-semibold">{{ $pilihan->kegunaan ?? '-' }}</span>
                </p>
            </div>
            <a href="{{ route('keutamaan.borang') }}"
               class="text-sm font-semibold bg-blue-50 text-blue-600 px-4 py-2 rounded-xl hover:bg-blue-100 transition">
                🔄 Cuba Semula
            </a>
        </div>

        {{-- Ringkasan Statistik --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-4 mb-5 flex items-center gap-8">
            <div class="text-center">
                <p class="text-xl font-bold text-gray-800">{{ count($cadangan ?? []) }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Cadangan Dijumpai</p>
            </div>
            <div class="w-px h-8 bg-gray-100"></div>
            <div class="text-center">
                <p class="text-xl font-bold text-blue-600">{{ $cadangan->first()->skor_padanan ?? 0 }}%</p>
                <p class="text-xs text-gray-400 mt-0.5">Padanan Tertinggi</p>
            </div>
            <div class="w-px h-8 bg-gray-100"></div>
            <div class="text-center">
                <p class="text-xl font-bold text-gray-800">RM {{ number_format($cadangan->min('peranti.harga') ?? 0, 0) }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Harga Terendah</p>
            </div>
            <div class="w-px h-8 bg-gray-100"></div>
            <div class="text-center">
                <p class="text-xl">{{ $pilihan->jenis === 'Speaker' ? '🔊' : ($pilihan->jenis === 'Mikrofon' ? '🎤' : ($pilihan->jenis === 'Earphone' ? '🎵' : '🎧')) }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ $pilihan->jenis ?? '-' }}</p>
            </div>
        </div>

        {{-- Grid Kad Cadangan --}}
        @forelse($cadangan ?? [] as $item)
            <div class="grid grid-cols-3 gap-5 mb-5">
                <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden card-hover">

                    {{-- Gambar Peranti --}}
                    <div class="h-36 flex items-center justify-center text-5xl"
                         style="background: {{ $loop->index === 0 ? '#eef0fe' : ($loop->index === 1 ? '#f3eeff' : '#edfdf5') }};">
                        @if($item->peranti->kategori === 'Speaker') 🔊
                        @elseif($item->peranti->kategori === 'Mikrofon') 🎤
                        @elseif($item->peranti->kategori === 'Earphone') 🎵
                        @else 🎧
                        @endif
                    </div>

                    <div class="p-4">
                        {{-- Badge Padanan --}}
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full
                                {{ $item->skor_padanan >= 80 ? 'bg-green-50 text-green-600' : 'bg-blue-50 text-blue-600' }}">
                                {{ $item->skor_padanan }}% Padan
                            </span>
                            @if($loop->first)
                                <span class="text-xs font-bold bg-yellow-50 text-yellow-600 px-2.5 py-1 rounded-full">🏆 Terbaik</span>
                            @endif
                        </div>

                        <h3 class="text-sm font-bold text-gray-800 mb-1">{{ $item->peranti->nama }}</h3>
                        <p class="text-xs text-gray-400 mb-2">{{ $item->peranti->jenama }} • {{ $item->peranti->kategori }}</p>
                        <p class="text-base font-bold text-blue-600 mb-3">RM {{ number_format($item->peranti->harga, 2) }}</p>

                        {{-- Tag --}}
                        <div class="flex flex-wrap gap-1.5 mb-3">
                            <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">{{ $item->peranti->kategori }}</span>
                        </div>

                        {{-- Rating --}}
                        <div class="flex items-center gap-1 mb-3">
                            <span class="text-yellow-400 text-xs">★★★★★</span>
                            <span class="text-xs text-gray-400">{{ number_format($item->peranti->skor_purata ?? 0, 1) }}</span>
                        </div>

                        {{-- Butang --}}
                        <a href="#"
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2.5 rounded-xl flex items-center justify-center transition">
                            Lihat Details →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            {{-- Tiada Cadangan --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-16 text-center">
                <p class="text-5xl mb-4">😔</p>
                <h2 class="text-base font-bold text-gray-700 mb-2">Tiada cadangan dijumpai</h2>
                <p class="text-sm text-gray-400 mb-5">Cuba ubah keutamaan anda untuk hasil yang lebih baik</p>
                <a href="{{ route('keutamaan.borang') }}"
                   class="inline-block bg-blue-600 text-white text-sm font-semibold px-6 py-3 rounded-xl hover:bg-blue-700 transition">
                    🔄 Cuba Semula
                </a>
            </div>
        @endforelse

    </main>

</body>
</html>