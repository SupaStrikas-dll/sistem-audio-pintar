<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengurusan Ulasan - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: 8px; font-size: 13px; color: rgba(255,255,255,0.55); margin-bottom: 2px; transition: all 0.15s; }
        .nav-item:hover { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.85); }
        .nav-active { background: #4f6ef7 !important; color: white !important; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex">

    <aside class="w-52 bg-[#1e1b4b] min-h-screen flex flex-col fixed left-0 top-0 z-40">
        <div class="px-4 py-5 border-b border-white/10">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-[#4f6ef7] rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24"><path d="M12 3a9 9 0 0 0-9 9 9 9 0 0 0 9 9 9 9 0 0 0 9-9 9 9 0 0 0-9-9zm0 2a7 7 0 0 1 7 7 7 7 0 0 1-7 7A7 7 0 0 1 5 12 7 7 0 0 1 12 5zm0 2a5 5 0 0 0-5 5 5 5 0 0 0 5 5 5 5 0 0 0 5-5 5 5 0 0 0-5-5zm0 2a3 3 0 0 1 3 3 3 3 0 0 1-3 3 3 3 0 0 1-3-3 3 3 0 0 1 3-3z"/></svg>
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
            <a href="{{ route('admin.ulasan') }}" class="nav-item nav-active">Ulasan</a>
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
            <h1 class="text-lg font-bold text-gray-800">Pengurusan Ulasan</h1>
            <p class="text-sm text-gray-400 mt-0.5">Semak dan urus semua ulasan pengguna</p>
        </div>

        @if(session('berjaya'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl mb-5">
                {{ session('berjaya') }}
            </div>
        @endif

        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Bil.</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Pengguna</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Peranti</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Penilaian</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Komen</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Tarikh</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ulasan ?? [] as $index => $u)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="px-5 py-3.5 text-sm text-gray-400">{{ $index + 1 }}</td>
                            <td class="px-5 py-3.5 text-sm font-semibold text-gray-700">
                                {{ $u->pengguna->nama ?? '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-sm text-gray-600">
                                {{ $u->peranti->nama ?? '-' }}
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="text-sm {{ $i <= $u->penilaian ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                                    @endfor
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-sm text-gray-500 max-w-xs truncate">
                                {{ $u->komen ?? 'Tiada komen.' }}
                            </td>
                            <td class="px-5 py-3.5 text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($u->tarikh)->format('d M Y') }}
                            </td>
                            <td class="px-5 py-3.5">
                                <form method="POST" action="{{ route('admin.ulasan.padam', $u->id) }}"
                                      onsubmit="return confirm('Padam ulasan ini?')">
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
                            <td colspan="7" class="text-center py-12 text-sm text-gray-400">Tiada ulasan dijumpai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-5 py-3.5 border-t border-gray-100">
                <div>{{ $ulasan->links() ?? '' }}</div>
            </div>
        </div>
    </main>
</body>
</html>