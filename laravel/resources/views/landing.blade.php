<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audio Pintar - Sistem Cadangan Peranti Audio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-hero { background: linear-gradient(135deg, #4f6ef7 0%, #7c3aed 100%); }
        .card-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(79, 110, 247, 0.12); }
        .btn-primary { background: #4f6ef7; transition: background 0.2s ease; }
        .btn-primary:hover { background: #3d5ce3; }
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-[#f8f9ff] text-[#1a1a2e]">

    {{-- ==================== NAVIGASI ==================== --}}
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">

            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 gradient-hero rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 fill-white" viewBox="0 0 24 24"><path d="M12 3a9 9 0 0 0-9 9 9 9 0 0 0 9 9 9 9 0 0 0 9-9 9 9 0 0 0-9-9zm0 2a7 7 0 0 1 7 7 7 7 0 0 1-7 7A7 7 0 0 1 5 12 7 7 0 0 1 12 5zm0 2a5 5 0 0 0-5 5 5 5 0 0 0 5 5 5 5 0 0 0 5-5 5 5 0 0 0-5-5zm0 2a3 3 0 0 1 3 3 3 3 0 0 1-3 3 3 3 0 0 1-3-3 3 3 0 0 1 3-3z"/></svg>
                </div>
                <span class="text-base font-bold">Audio<span class="text-[#4f6ef7]">Pintar</span></span>
            </div>

            {{-- Link Navigasi --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="#" class="text-sm text-gray-500 font-medium hover:text-[#4f6ef7] transition">Laman Utama</a>
                <a href="#ciri" class="text-sm text-gray-500 font-medium hover:text-[#4f6ef7] transition">Ciri-Ciri</a>
                <a href="#cara" class="text-sm text-gray-500 font-medium hover:text-[#4f6ef7] transition">Cara Guna</a>
                <a href="#" class="text-sm text-gray-500 font-medium hover:text-[#4f6ef7] transition">Tentang Kami</a>
            </div>

            {{-- Butang --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}"
                   class="text-sm font-semibold text-[#4f6ef7] border border-[#4f6ef7] px-5 py-2 rounded-lg hover:bg-blue-50 transition">
                    Log Masuk
                </a>
                <a href="{{ route('daftar') }}"
                   class="text-sm font-semibold text-white btn-primary px-5 py-2 rounded-lg">
                    Daftar Percuma
                </a>
            </div>

        </div>
    </nav>

    {{-- ==================== HERO ==================== --}}
    <section class="bg-white py-20 px-6 text-center">
        <div class="max-w-3xl mx-auto">

            {{-- Tajuk Utama --}}
            <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-5">
                Cari Peranti Audio <span class="text-[#4f6ef7]">Terbaik</span> Untuk Anda
            </h1>

            {{-- Penerangan --}}
            <p class="text-gray-500 text-base leading-relaxed mb-8 max-w-lg mx-auto">
                Jawab beberapa soalan mudah dan sistem kami akan mencadangkan peranti audio yang paling sesuai dengan keperluan dan bajet anda.
            </p>

            {{-- Butang CTA --}}
            <div class="flex items-center justify-center gap-4 flex-wrap">
                <a href="{{ route('daftar') }}"
                   class="text-sm font-semibold text-white btn-primary px-7 py-3 rounded-lg">
                    Mula Sekarang 
                </a>
                <a href="#cara"
                   class="text-sm font-semibold text-[#4f6ef7] border border-[#4f6ef7] px-7 py-3 rounded-lg hover:bg-blue-50 transition">
                    Ketahui Lebih Lanjut
                </a>
            </div>

        </div>
    </section>

    {{-- ==================== CIRI-CIRI ==================== --}}
    <section id="ciri" class="py-20 px-6 bg-[#f8f9ff]">
        <div class="max-w-5xl mx-auto">

            <p class="text-xs font-bold text-[#4f6ef7] text-center tracking-widest uppercase mb-3">Ciri-Ciri Utama</p>
            <h2 class="text-2xl font-bold text-center mb-2">Kenapa Pilih Audio Pintar?</h2>

            <div class="grid md:grid-cols-3 gap-5">

                <div class="bg-white border border-gray-100 rounded-2xl p-6 card-hover">
                    <h3 class="text-sm font-semibold mb-2">Cadangan Tepat</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Sistem kami menganalisis keutamaan anda dan mencadangkan peranti yang paling sesuai berdasarkan bajet dan keperluan.</p>
                </div>

                <div class="bg-white border border-gray-100 rounded-2xl p-6 card-hover">
                    <h3 class="text-sm font-semibold mb-2">Ulasan Pengguna</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Baca ulasan dan penilaian daripada pengguna lain sebelum membuat keputusan pembelian anda.</p>
                </div>

                <div class="bg-white border border-gray-100 rounded-2xl p-6 card-hover">
                    <h3 class="text-sm font-semibold mb-2">Perbandingan Mudah</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Bandingkan pelbagai peranti audio dengan mudah mengikut spesifikasi, harga dan ciri-ciri.</p>
                </div>

                <div class="bg-white border border-gray-100 rounded-2xl p-6 card-hover">
                    <h3 class="text-sm font-semibold mb-2">Selamat & Terjamin</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Data peribadi anda dilindungi sepenuhnya dengan sistem keselamatan yang terkini.</p>
                </div>

                <div class="bg-white border border-gray-100 rounded-2xl p-6 card-hover">
                    <h3 class="text-sm font-semibold mb-2">Mesra Pengguna</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Antara muka yang bersih dan mudah digunakan oleh semua peringkat pengguna.</p>
                </div>

                <div class="bg-white border border-gray-100 rounded-2xl p-6 card-hover">
                    <h3 class="text-sm font-semibold mb-2">Sejarah Cadangan</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Simpan dan semak semula sejarah cadangan anda pada bila-bila masa yang dikehendaki.</p>
                </div>

            </div>
        </div>
    </section>

    {{-- ==================== CARA GUNA ==================== --}}
    <section id="cara" class="py-20 px-6 bg-white">
        <div class="max-w-2xl mx-auto">

            <p class="text-xs font-bold text-[#4f6ef7] text-center tracking-widest uppercase mb-3">Cara Penggunaan</p>
            <h2 class="text-2xl font-bold text-center mb-2">Mudah, Cepat & Tepat</h2>
            <p class="text-sm text-gray-500 text-center mb-12">Hanya 3 langkah untuk dapatkan cadangan terbaik</p>

            <div class="flex flex-col gap-4">

                <div class="flex gap-4 items-start bg-[#f8f9ff] border border-gray-100 rounded-2xl p-5">
                    <div class="w-10 h-10 bg-blue-50 text-[#4f6ef7] rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">1</div>
                    <div>
                        <h4 class="text-sm font-semibold mb-1">Daftar & Log Masuk</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Buat akaun percuma anda dalam masa kurang dari 1 minit. Tiada bayaran diperlukan.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start bg-[#f8f9ff] border border-gray-100 rounded-2xl p-5">
                    <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">2</div>
                    <div>
                        <h4 class="text-sm font-semibold mb-1">Isi Borang Keutamaan</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Beritahu kami bajet, jenis peranti, kegunaan dan keutamaan audio anda melalui borang mudah.</p>
                    </div>
                </div>

                <div class="flex gap-4 items-start bg-[#f8f9ff] border border-gray-100 rounded-2xl p-5">
                    <div class="w-10 h-10 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">3</div>
                    <div>
                        <h4 class="text-sm font-semibold mb-1">Dapatkan Cadangan</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Sistem kami akan terus memberikan senarai peranti audio terbaik yang sesuai untuk anda!</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ==================== CTA ==================== --}}
    <section class="px-6 pb-20">
        <div class="max-w-5xl mx-auto gradient-hero rounded-3xl py-14 px-8 text-center">
            <h2 class="text-2xl font-bold text-white mb-3">Sedia Untuk Mula?</h2>
            <p class="text-sm text-white/80 mb-8">Daftar sekarang secara percuma dan dapatkan cadangan peranti audio terbaik untuk anda.</p>
            <a href="{{ route('daftar') }}"
               class="inline-block bg-white text-[#4f6ef7] text-sm font-bold px-8 py-3 rounded-xl hover:bg-blue-50 transition">
                Daftar Percuma 
            </a>
        </div>
    </section>

    {{-- ==================== FOOTER ==================== --}}
    <footer class="bg-white border-t border-gray-100 py-6 px-6 text-center">
        <p class="text-xs text-gray-400">© {{ date('Y') }} Audio Pintar. Sistem  Cadangan  Peranti  Audio. Hak  Cipta   Terpelihara.</p>
    </footer>

</body>
</html>