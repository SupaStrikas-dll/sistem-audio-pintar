<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Sistem Cadangan Audio</title>
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
                    <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24">
                        <path d="M12 3a9 9 0 0 0-9 9 9 9 0 0 0 9 9 9 9 0 0 0 9-9 9 9 0 0 0-9-9zm0 2a7 7 0 0 1 7 7 7 7 0 0 1-7 7A7 7 0 0 1 5 12 7 7 0 0 1 12 5zm0 2a5 5 0 0 0-5 5 5 5 0 0 0 5 5 5 5 0 0 0 5-5 5 5 0 0 0-5-5zm0 2a3 3 0 0 1 3 3 3 3 0 0 1-3 3 3 3 0 0 1-3-3 3 3 0 0 1 3-3z" />
                    </svg>
                </div>
                <span class="text-sm font-bold">Audio<span class="text-blue-600">Pintar</span></span>
            </div>
        </div>
        <nav class="flex-1 py-4 px-3">
            <p class="text-xs font-semibold text-gray-400 px-3 mb-2 uppercase tracking-wider">Menu Utama</p>
            <a href="{{ route('pengguna.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">Dashboard</a>
            <a href="{{ route('keutamaan.borang') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">Cadangan Baru</a>
            <a href="{{ route('sejarah.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">Sejarah Cadangan</a>
            <a href="{{ route('ulasan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">Ulasan Saya</a>
            <p class="text-xs font-semibold text-gray-400 px-3 mt-5 mb-2 uppercase tracking-wider">Akaun</p>
            <a href="{{ route('profil.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm mb-1" style="background:#eef0fe;color:#4f6ef7;font-weight:600;border-left:3px solid #4f6ef7;">Profil Saya</a>
            <form method="POST" action="{{ route('logout') }}">
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
            <h1 class="text-lg font-bold text-gray-800">Profil Saya</h1>
            <p class="text-sm text-gray-400 mt-0.5">Urus maklumat peribadi anda</p>
        </div>

        {{-- Mesej --}}
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

        <div class="grid grid-cols-3 gap-5">

            {{-- Kad Profil --}}
            <div class="col-span-1">
                <div class="bg-white border border-gray-100 rounded-2xl p-6 text-center">
                    <div class="w-20 h-20 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-2xl font-bold uppercase mx-auto mb-4">
                        {{ strtoupper(substr(auth()->user()->nama ?? 'U', 0, 2)) }}
                    </div>
                    <h2 class="text-base font-bold text-gray-800">{{ auth()->user()->nama }}</h2>
                    <p class="text-sm text-gray-400 mt-1">{{ auth()->user()->emel }}</p>
                    <span class="inline-block mt-3 text-xs font-semibold bg-green-50 text-green-600 px-3 py-1 rounded-full">
                        Akaun Aktif
                    </span>
                    <div class="mt-4 pt-4 border-t border-gray-100 text-left space-y-2">
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-400">Ahli sejak</span>
                            <span class="font-semibold text-gray-600">{{ auth()->user()->created_at->format('M Y') }}</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-400">Peranan</span>
                            <span class="font-semibold text-gray-600">Pengguna</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Borang Kemaskini --}}
            <div class="col-span-2 space-y-5">

                {{-- Maklumat Peribadi --}}
                <div class="bg-white border border-gray-100 rounded-2xl p-6">
                    <h3 class="text-sm font-bold text-gray-700 mb-5">Maklumat Peribadi</h3>
                    <form method="POST" action="{{ route('profil.kemaskini') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Nama Penuh</label>
                            <input
                                type="text"
                                name="nama"
                                value="{{ old('nama', auth()->user()->nama) }}"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                                required>
                        </div>

                        <div class="mb-5">
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Alamat Emel</label>
                            <input
                                type="email"
                                name="emel"
                                value="{{ old('emel', auth()->user()->emel) }}"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                                required>
                        </div>

                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

                {{-- Tukar Kata Laluan --}}
                <div class="bg-white border border-gray-100 rounded-2xl p-6">
                    <h3 class="text-sm font-bold text-gray-700 mb-5">Tukar Kata Laluan</h3>
                    <form method="POST" action="{{ route('profil.tukarKataLaluan') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Kata Laluan Semasa</label>
                            <input
                                type="password"
                                name="kata_laluan_semasa"
                                placeholder="Masukkan kata laluan semasa"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Kata Laluan Baru</label>
                            <input
                                type="password"
                                name="kata_laluan_baru"
                                placeholder="Minimum 6 aksara"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>

                        <div class="mb-5">
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Sahkan Kata Laluan Baru</label>
                            <input
                                type="password"
                                name="kata_laluan_baru_confirmation"
                                placeholder="Ulang kata laluan baru"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>

                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition">
                            Tukar Kata Laluan
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </main>

</body>

</html>