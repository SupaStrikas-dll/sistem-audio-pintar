<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akaun - Sistem Cadangan Audio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Background gambar IEM lutsinar (clear resin) daripada Unsplash */
        .register-bg {
            background-image: url('https://images.unsplash.com/photo-1628202926206-c63a34b1618f?w=1920&q=80](https://images.unsplash.com/photo-1628202926206-c63a34b1618f?w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }

        /* Overlay gelap premium untuk kontras kad pendaftaran */
        .register-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(15, 20, 35, 0.75) 0%, rgba(25, 15, 40, 0.85) 100%);
            z-index: 0;
        }

        /* Memastikan kandungan berada di atas overlay */
        .register-content {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body class="register-bg min-h-screen flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-md register-content">

        {{-- Logo --}}
        <div class="text-center mb-6">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-2 rounded-xl border border-white/10 shadow-lg">
                <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 fill-white" viewBox="0 0 24 24"><path d="M12 3a9 9 0 0 0-9 9 9 9 0 0 0 9 9 9 9 0 0 0 9-9 9 9 0 0 0-9-9zm0 2a7 7 0 0 1 7 7 7 7 0 0 1-7 7A7 7 0 0 1 5 12 7 7 0 0 1 12 5zm0 2a5 5 0 0 0-5 5 5 5 0 0 0 5 5 5 5 0 0 0 5-5 5 5 0 0 0-5-5zm0 2a3 3 0 0 1 3 3 3 3 0 0 1-3 3 3 3 0 0 1-3-3 3 3 0 0 1 3-3z"/></svg>
                </div>
                <span class="text-base font-bold text-white">Audio<span class="text-blue-400">Pintar</span></span>
            </a>
        </div>

        {{-- Kad Daftar --}}
        <div class="bg-white/95 backdrop-blur-md rounded-2xl border border-white/20 shadow-2xl p-8">

            <div class="text-center mb-7">
                <h1 class="text-xl font-bold text-gray-800">Daftar Akaun Baru</h1>
                <p class="text-sm text-gray-500 mt-1">Percuma selamanya. Tiada kad kredit diperlukan.</p>
            </div>

            {{-- Mesej Ralat --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl mb-5">
                    ⚠️ {{ $errors->first() }}
                </div>
            @endif

            {{-- Borang --}}
            <form method="POST" action="{{ route('prosesDaftar') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1.5">Nama Penuh</label>
                    <input
                        type="text"
                        name="nama"
                        value="{{ old('nama') }}"
                        placeholder="Masukkan nama penuh anda"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-400 transition"
                    >
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1.5">Alamat Emel</label>
                    <input
                        type="email"
                        name="emel"
                        value="{{ old('emel') }}"
                        placeholder="contoh@emel.com"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-400 transition"
                    >
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1.5">Kata Laluan</label>
                    <input
                        type="password"
                        name="kata_laluan"
                        placeholder="Minimum 6 aksara"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-400 transition"
                    >
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-600 mb-1.5">Sahkan Kata Laluan</label>
                    <input
                        type="password"
                        name="kata_laluan_confirmation"
                        placeholder="Ulang kata laluan anda"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-400 transition"
                    >
                </div>

                <button type="submit"
                    class="w-full bg-purple-600 hover:bg-purple-700 active:scale-95 text-white font-semibold py-3 rounded-xl text-sm transition shadow-md shadow-purple-600/20">
                    Daftar Sekarang 
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Sudah ada akaun?
                <a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:underline">Log masuk di sini</a>
            </p>

        </div>

        <p class="text-center text-xs mt-5">
            <a href="{{ route('landing') }}" class="text-white/70 hover:text-white hover:underline transition">
                ← Kembali ke laman utama
            </a>
        </p>

    </div>

</body>
</html>