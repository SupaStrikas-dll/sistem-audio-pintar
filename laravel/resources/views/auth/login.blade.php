<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk - Sistem Cadangan Audio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-purple-50 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-2">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 fill-white" viewBox="0 0 24 24"><path d="M12 3a9 9 0 0 0-9 9 9 9 0 0 0 9 9 9 9 0 0 0 9-9 9 9 0 0 0-9-9zm0 2a7 7 0 0 1 7 7 7 7 0 0 1-7 7A7 7 0 0 1 5 12 7 7 0 0 1 12 5zm0 2a5 5 0 0 0-5 5 5 5 0 0 0 5 5 5 5 0 0 0 5-5 5 5 0 0 0-5-5zm0 2a3 3 0 0 1 3 3 3 3 0 0 1-3 3 3 3 0 0 1-3-3 3 3 0 0 1 3-3z"/></svg>
                </div>
                <span class="text-lg font-bold text-gray-800">Audio<span class="text-blue-600">Cari</span></span>
            </a>
        </div>

        {{-- Kad Login --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">

            <div class="text-center mb-7">
                <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">🎧</div>
                <h1 class="text-xl font-bold text-gray-800">Selamat Kembali!</h1>
                <p class="text-sm text-gray-400 mt-1">Sila log masuk untuk teruskan</p>
            </div>

            {{-- Mesej Berjaya --}}
            @if(session('berjaya'))
                <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl mb-5">
                    ✅ {{ session('berjaya') }}
                </div>
            @endif

            {{-- Mesej Ralat --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl mb-5">
                    ⚠️ {{ $errors->first() }}
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
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition"
                    >
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-600 mb-1.5">Kata Laluan</label>
                    <input
                        type="password"
                        name="kata_laluan"
                        placeholder="Masukkan kata laluan"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition"
                    >
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-semibold py-3 rounded-xl text-sm transition">
                    Log Masuk →
                </button>
            </form>

            <p class="text-center text-sm text-gray-400 mt-6">
                Belum ada akaun?
                <a href="{{ route('daftar') }}" class="text-blue-600 font-semibold hover:underline">Daftar percuma</a>
            </p>

        </div>

        <p class="text-center text-xs text-gray-400 mt-5">
            <a href="{{ route('landing') }}" class="hover:text-blue-500 transition">← Kembali ke laman utama</a>
        </p>

    </div>

</body>
</html>