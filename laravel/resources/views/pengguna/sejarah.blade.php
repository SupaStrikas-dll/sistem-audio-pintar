<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sejarah Cadangan - Sistem Cadangan Audio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="w-56 bg-white border-r border-gray-100 min-h-screen flex flex-col fixed left-0 top-0 z-40">
        <div class="px-5 py-5 border-b border-gray-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round">
                        <line x1="4" y1="16" x2="4" y2="20" />
                        <line x1="9" y1="10" x2="9" y2="20" />
                        <line x1="14" y1="4" x2="14" y2="20" />
                        <line x1="19" y1="12" x2="19" y2="20" />
                    </svg>
                </div>
                <span class="text-sm font-bold">Audio<span class="text-blue-600">Pintar</span></span>
            </div>
        </div>
        <nav class="flex-1 py-4 px-3">
            <p class="text-xs font-semibold text-gray-400 px-3 mb-2 uppercase tracking-wider">Menu Utama</p>
            <a href="{{ route('pengguna.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">Dashboard</a>
            <a href="{{ route('keutamaan.borang') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">Cadangan Baru</a>
            <a href="{{ route('sejarah.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm mb-1" style="background:#eef0fe;color:#4f6ef7;font-weight:600;border-left:3px solid #4f6ef7;">Sejarah Cadangan</a>
            <a href="{{ route('ulasan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">Ulasan Saya</a>
            <p class="text-xs font-semibold text-gray-400 px-3 mt-5 mb-2 uppercase tracking-wider">Akaun</p>
            <a href="{{ route('profil.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">Profil Saya</a>
            <form method="POST" action="{{ route('logout') }}"
                onsubmit="return confirm('Adakah anda pasti mahu log keluar?')">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-red-400 hover:bg-red-50 transition text-left">Log Keluar</button>
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

    {{-- KANDUNGAN --}}
    <main class="ml-56 flex-1 p-6">

        <div class="mb-6">
            <h1 class="text-lg font-bold text-gray-800">Sejarah Cadangan</h1>
            <p class="text-sm text-gray-400 mt-0.5">Semua carian peranti audio yang pernah anda buat</p>
        </div>

        @forelse($sejarah ?? [] as $pilihan)
        <div class="bg-white border border-gray-100 rounded-2xl p-5 mb-4">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-4">
                <div>
                    <span class="text-xs font-semibold bg-blue-50 text-blue-600 px-3 py-1 rounded-full">
                        {{ $pilihan->jenis }}
                    </span>
                    <span class="text-xs text-gray-400 ml-2">
                        {{ \Carbon\Carbon::parse($pilihan->created_at)->format('d M Y, h:i A') }}
                    </span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-400">
                        Bajet: <span class="font-semibold text-gray-700">RM {{ number_format($pilihan->bajet, 0) }}</span>
                    </span>
                    <span class="text-xs text-gray-400">
                        Kegunaan: <span class="font-semibold text-gray-700">{{ $pilihan->kegunaan }}</span>
                    </span>
                    <a href="{{ route('cadangan.hasil', $pilihan->id) }}"
                        class="text-xs font-semibold bg-blue-600 text-white px-4 py-1.5 rounded-lg hover:bg-blue-700 transition">
                        Lihat Cadangan
                    </a>
                </div>
            </div>

            {{-- Senarai Cadangan --}}
            @if($pilihan->cadangan->count() > 0)
            <div class="grid grid-cols-3 gap-3">
                @foreach($pilihan->cadangan->sortByDesc('skor_padanan')->take(3) as $c)
                <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 flex items-center gap-3">
                    @if($c->peranti->imej)
                    <img src="{{ asset($c->peranti->imej) }}"
                        alt="{{ $c->peranti->nama }}"
                        class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                    @else
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-lg flex-shrink-0">
                        {{ ($c->peranti->kategori->nama_kategori ?? '') === 'Speaker' ? '🔊' : (($c->peranti->kategori->nama_kategori ?? '') === 'Mikrofon' ? '🎤' : '🎧') }}
                    </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-700 truncate">{{ $c->peranti->nama ?? '-' }}</p>
                        <p class="text-xs text-gray-400">RM {{ number_format($c->peranti->harga ?? 0, 0) }}</p>
                    </div>
                    <span class="text-xs font-bold {{ $c->skor_padanan >= 80 ? 'text-green-600' : 'text-blue-600' }} flex-shrink-0">
                        {{ $c->skor_padanan }}%
                    </span>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-xs text-gray-400 text-center py-3">Tiada cadangan dijana untuk carian ini.</p>
            @endif

        </div>
        @empty
        <div class="bg-white border border-gray-100 rounded-2xl p-16 text-center">
            <h2 class="text-base font-bold text-gray-700 mb-2">Tiada sejarah cadangan</h2>
            <p class="text-sm text-gray-400 mb-5">Mulakan carian peranti audio anda sekarang</p>
            <a href="{{ route('keutamaan.borang') }}"
                class="inline-block bg-blue-600 text-white text-sm font-semibold px-6 py-3 rounded-xl hover:bg-blue-700 transition">
                Mula Carian
            </a>
        </div>
        @endforelse

    </main>

</body>

</html>