<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk - Sistem Cadangan Audio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Pautan diperbaiki menggunakan struktur URL Unsplash Source API yang stabil */
        .login-bg {
            background-image: url('https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }

        /* Overlay gelap bagi memastikan kad login kelihatan timbul dan teks mudah dibaca */
        .login-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(15, 10, 5, 0.55) 0%, rgba(10, 10, 15, 0.75) 100%);
            z-index: 0;
        }

        /* Memastikan kandungan berada di atas lapisan overlay */
        .login-content {
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body class="login-bg min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md login-content my-8">

        {{-- Logo --}}
        <div class="text-center mb-6">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-2 rounded-xl border border-white/10 shadow-lg">
                <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round">
                        <line x1="4" y1="16" x2="4" y2="20" />
                        <line x1="9" y1="10" x2="9" y2="20" />
                        <line x1="14" y1="4" x2="14" y2="20" />
                        <line x1="19" y1="12" x2="19" y2="20" />
                    </svg>
                </div>
                <span class="text-base font-bold text-white">Audio<span class="text-blue-400">Pintar</span></span>
            </a>
        </div>

        {{-- Kad Login --}}
        <div class="bg-white/95 backdrop-blur-md rounded-2xl border border-white/20 shadow-2xl p-8">

            <div class="text-center mb-7">
                <h1 class="text-xl font-bold text-gray-800">Selamat Kembali!</h1>
                <p class="text-sm text-gray-500 mt-1">Sila log masuk untuk teruskan</p>
            </div>

            {{-- Mesej Berjaya --}}
            @if(session('berjaya'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl mb-5">
                {{ session('berjaya') }}
            </div>
            @endif

            {{-- Mesej Ralat --}}
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl mb-5">
                {{ $errors->first() }}
            </div>
            @endif

            {{-- Borang --}}
            <form method="POST" action="{{ route('prosesLogin') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1.5">Alamat Emel</label>
                    <input
                        type="email"
                        name="emel"
                        value="{{ old('emel') }}"
                        placeholder="contoh@emel.com"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-600 mb-1.5">Kata Laluan</label>
                    <input
                        type="password"
                        name="kata_laluan"
                        placeholder="Masukkan kata laluan"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-semibold py-3 rounded-xl text-sm transition shadow-md shadow-blue-600/20">
                    Log Masuk
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Belum ada akaun?
                <a href="{{ route('daftar') }}" class="text-blue-600 font-semibold hover:underline">Daftar percuma</a>
            </p>

        </div>

        <p class="text-center text-sm mt-5">
            <a href="{{ route('landing') }}" class="text-white/80 hover:text-white hover:underline transition text-xs font-medium">
                Kembali ke laman utama
            </a>
        </p>

    </div>

</body>

</html>