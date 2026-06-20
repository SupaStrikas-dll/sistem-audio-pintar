<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengurusan Peranti Audio - Admin</title>
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

    {{-- ==================== SIDEBAR ADMIN ==================== --}}
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
            <a href="{{ route('admin.peranti') }}" class="nav-item nav-active">Peranti Audio</a>
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

    {{-- ==================== KANDUNGAN UTAMA ==================== --}}
    <main class="ml-52 flex-1 p-6">

        {{-- Topbar --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-lg font-bold text-gray-800">Pengurusan Peranti Audio</h1>
                <p class="text-sm text-gray-400 mt-0.5">Urus semua peranti audio dalam sistem</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.peranti.eksport') }}"
                   class="text-sm font-semibold border border-gray-200 text-gray-600 bg-white px-5 py-2.5 rounded-xl hover:bg-gray-50 transition flex items-center gap-2">
                     Eksport CSV
                </a>
                <a href="{{ route('admin.peranti.tambah') }}"
                   class="text-sm font-semibold bg-[#4f6ef7] text-white px-5 py-2.5 rounded-xl hover:bg-blue-700 transition flex items-center gap-2">
                    + Tambah Peranti
                </a>
            </div>
        </div>

        {{-- Mesej Berjaya --}}
        @if(session('berjaya'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl mb-5">
                {{ session('berjaya') }}
            </div>
        @endif

        {{-- Carian & Filter --}}
        <form method="GET" class="flex gap-3 mb-5">
            <input type="text" name="cari" value="{{ request('cari') }}"
                placeholder="Cari nama peranti atau jenama..."
                class="flex-1 bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">

            <select name="kategori" onchange="this.form.submit()"
                class="bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                <option value="">Semua Kategori</option>
                <option value="Fon Telinga" {{ request('kategori') == 'Fon Telinga' ? 'selected' : '' }}>Fon Telinga</option>
                <option value="Speaker" {{ request('kategori') == 'Speaker' ? 'selected' : '' }}>Speaker</option>
                <option value="Mikrofon" {{ request('kategori') == 'Mikrofon' ? 'selected' : '' }}>Mikrofon</option>
                <option value="Earphone" {{ request('kategori') == 'Earphone' ? 'selected' : '' }}>Earphone</option>
            </select>

            <select name="status" onchange="this.form.submit()"
                class="bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                <option value="">Semua Status</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>

            <button type="submit"
                class="bg-gray-800 text-white text-sm font-semibold px-6 py-2.5 rounded-xl hover:bg-gray-700 transition">
                Cari
            </button>
        </form>

        {{-- Jadual Peranti --}}
        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Bil.</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Nama Peranti</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Jenama</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Kategori</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Harga (RM)</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Status</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-5 py-3.5">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peranti ?? [] as $index => $p)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="px-5 py-3.5 text-sm text-gray-400">{{ $index + 1 }}</td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    @if($p->imej)
                                        <img src="{{ asset($p->imej) }}" alt="{{ $p->nama }}"
                                             class="w-9 h-9 rounded-lg object-cover flex-shrink-0">
                                    @else
                                        <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center text-sm flex-shrink-0">🎧</div>
                                    @endif
                                    <span class="text-sm font-semibold text-gray-700">{{ $p->nama }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-sm text-gray-500">{{ $p->jenama }}</td>
                            <td class="px-5 py-3.5">
                                <span class="text-xs font-semibold bg-blue-50 text-blue-600 px-2.5 py-1 rounded-full">
                                    {{ $p->kategori->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-sm text-gray-600">{{ number_format($p->harga, 2) }}</td>
                            <td class="px-5 py-3.5">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $p->status ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-500' }}">
                                    {{ $p->status ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.peranti.kemaskini', $p->id) }}"
                                        class="text-xs font-semibold bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg hover:bg-blue-100 transition">
                                        Kemaskini
                                    </a>
                                    <form method="POST" action="{{ route('admin.peranti.padam', $p->id) }}"
                                          onsubmit="return confirm('Padam peranti ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-xs font-semibold bg-red-50 text-red-500 px-3 py-1.5 rounded-lg hover:bg-red-100 transition">
                                            Padam
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-sm text-gray-400">Tiada peranti dijumpai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-5 py-3.5 border-t border-gray-100 flex items-center justify-between">
                <p class="text-xs text-gray-400">Menunjukkan {{ $peranti->firstItem() ?? 0 }} - {{ $peranti->lastItem() ?? 0 }} daripada {{ $peranti->total() ?? 0 }} rekod</p>
                <div>{{ $peranti->links() ?? '' }}</div>
            </div>
        </div>

    </main>

</body>
</html>