<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengurusan Cadangan - Admin</title>
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
            <a href="{{ route('admin.cadangan') }}" class="nav-item nav-active">Cadangan</a>
            <p class="text-xs font-semibold text-white/30 px-3 mt-5 mb-2 uppercase tracking-wider">Pengurusan</p>
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

    <main class="ml-52 flex-1 p-6">
        <div class="mb-6">
            <h1 class="text-lg font-bold text-gray-800">Pengurusan Cadangan</h1>
            <p class="text-sm text-gray-400 mt-0.5">Senarai semua cadangan yang telah dijana sistem</p>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Bil.</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Pengguna</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Peranti Dicadang</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Jenis</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Skor Padanan</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Tarikh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cadangan ?? [] as $index => $c)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="px-5 py-3.5 text-sm text-gray-400">{{ $index + 1 }}</td>
                        <td class="px-5 py-3.5 text-sm font-semibold text-gray-700">
                            {{ $c->pilihan->pengguna->nama ?? '-' }}
                        </td>
                        <td class="px-5 py-3.5 text-sm text-gray-700">
                            {{ $c->peranti->nama ?? '-' }}
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="text-xs font-semibold bg-blue-50 text-blue-600 px-2.5 py-1 rounded-full">
                                {{ $c->pilihan->jenis ?? '-' }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="text-sm font-bold {{ $c->skor_padanan >= 80 ? 'text-green-600' : 'text-blue-600' }}">
                                {{ $c->skor_padanan }}%
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($c->created_at)->format('d M Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-sm text-gray-400">Tiada cadangan dijumpai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-5 py-3.5 border-t border-gray-100">
                <div>{{ $cadangan->links() ?? '' }}</div>
            </div>
        </div>
    </main>
</body>

</html>