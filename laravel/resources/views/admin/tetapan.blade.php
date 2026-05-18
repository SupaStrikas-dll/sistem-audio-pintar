<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tetapan - Admin</title>
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
                    <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24">
                        <path d="M12 3a9 9 0 0 0-9 9 9 9 0 0 0 9 9 9 9 0 0 0 9-9 9 9 0 0 0-9-9zm0 2a7 7 0 0 1 7 7 7 7 0 0 1-7 7A7 7 0 0 1 5 12 7 7 0 0 1 12 5zm0 2a5 5 0 0 0-5 5 5 5 0 0 0 5 5 5 5 0 0 0 5-5 5 5 0 0 0-5-5zm0 2a3 3 0 0 1 3 3 3 3 0 0 1-3 3 3 3 0 0 1-3-3 3 3 0 0 1 3-3z" />
                    </svg>
                </div>
                <span class="text-sm font-bold text-white">Audio<span class="text-indigo-400">Cari</span></span>
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
            <a href="{{ route('admin.statistik') }}" class="nav-item">Statistik</a>
            <a href="{{ route('admin.tetapan') }}" class="nav-item nav-active">Tetapan</a>
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

    <main class="ml-52 flex-1 p-6">
        <div class="mb-6">
            <h1 class="text-lg font-bold text-gray-800">Tetapan Sistem</h1>
            <p class="text-sm text-gray-400 mt-0.5">Urus maklumat akaun pentadbir</p>
        </div>

        @if(session('berjaya'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl mb-5">
            {{ session('berjaya') }}
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl mb-5">
            {{ $errors->first() }}
        </div>
        @endif

        <div class="grid grid-cols-2 gap-5 max-w-3xl">

            <div class="bg-white border border-gray-100 rounded-2xl p-6">
                <h2 class="text-sm font-bold text-gray-700 mb-5">Maklumat Akaun</h2>
                <form method="POST" action="{{ route('admin.tetapan.kemaskini') }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama', auth()->user()->nama) }}"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                            required>
                    </div>
                    <div class="mb-5">
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Emel</label>
                        <input type="email" name="emel" value="{{ old('emel', auth()->user()->emel) }}"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                            required>
                    </div>
                    <button type="submit"
                        class="bg-[#4f6ef7] hover:bg-blue-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            <div class="bg-white border border-gray-100 rounded-2xl p-6">
                <h2 class="text-sm font-bold text-gray-700 mb-5">Tukar Kata Laluan</h2>
                <form method="POST" action="{{ route('admin.tetapan.kataLaluan') }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Kata Laluan Semasa</label>
                        <input type="password" name="kata_laluan_semasa"
                            placeholder="Masukkan kata laluan semasa"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Kata Laluan Baru</label>
                        <input type="password" name="kata_laluan_baru"
                            placeholder="Minimum 6 aksara"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>
                    <div class="mb-5">
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Sahkan Kata Laluan Baru</label>
                        <input type="password" name="kata_laluan_baru_confirmation"
                            placeholder="Ulang kata laluan baru"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>
                    <button type="submit"
                        class="bg-[#4f6ef7] hover:bg-blue-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition">
                        Tukar Kata Laluan
                    </button>
                </form>
            </div>

        </div>
    </main>
</body>

</html>