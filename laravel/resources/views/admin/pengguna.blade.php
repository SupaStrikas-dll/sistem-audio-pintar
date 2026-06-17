<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengurusan Pengguna - Admin</title>
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
            <a href="{{ route('admin.pengguna') }}" class="nav-item nav-active">Pengguna</a>
            <a href="{{ route('admin.peranti') }}" class="nav-item">Peranti Audio</a>
            <a href="{{ route('admin.cadangan') }}" class="nav-item">Cadangan</a>
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
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-lg font-bold text-gray-800">Pengurusan Pengguna</h1>
                <p class="text-sm text-gray-400 mt-0.5">Senarai semua pengguna berdaftar dalam sistem</p>
            </div>
        </div>

        @if(session('berjaya'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl mb-5">
            {{ session('berjaya') }}
        </div>
        @endif

        <form method="GET" class="flex gap-3 mb-5">
            <input type="text" name="cari" value="{{ request('cari') }}"
                placeholder="Cari nama atau emel pengguna..."
                class="flex-1 bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
            <button type="submit" class="bg-gray-800 text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-gray-700 transition">Cari</button>
        </form>

        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Bil.</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Nama</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Emel</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Peranan</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Tarikh Daftar</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengguna ?? [] as $index => $p)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="px-5 py-3.5 text-sm text-gray-400">{{ $index + 1 }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold uppercase">
                                    {{ strtoupper(substr($p->nama, 0, 2)) }}
                                </div>
                                <span class="text-sm font-semibold text-gray-700">{{ $p->nama }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-sm text-gray-500">{{ $p->emel }}</td>
                        <td class="px-5 py-3.5">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $p->peranan === 'pentadbir' ? 'bg-purple-50 text-purple-600' : 'bg-blue-50 text-blue-600' }}">
                                {{ ucfirst($p->peranan) }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}
                        </td>
                        <td class="px-5 py-3.5">
                            <form method="POST" action="{{ route('admin.pengguna.padam', $p->id) }}"
                                onsubmit="return confirm('Padam pengguna ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-xs font-semibold bg-red-50 text-red-500 px-3 py-1.5 rounded-lg hover:bg-red-100 transition">
                                    Padam
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-sm text-gray-400">Tiada pengguna dijumpai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-5 py-3.5 border-t border-gray-100 flex items-center justify-between">
                <p class="text-xs text-gray-400">Jumlah: {{ $pengguna->total() ?? 0 }} pengguna</p>
                <div>{{ $pengguna->links() ?? '' }}</div>
            </div>
        </div>
    </main>
</body>

</html>