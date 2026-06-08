<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan & Penilaian - Sistem Cadangan Audio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .star {
            font-size: 28px;
            cursor: pointer;
            color: #d1d5db;
            transition: color 0.1s;
        }

        .star.active {
            color: #f59e0b;
        }

        .star:hover {
            color: #f59e0b;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex">

    {{-- ==================== SIDEBAR ==================== --}}
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
            <a href="{{ route('ulasan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm mb-1" style="background:#eef0fe;color:#4f6ef7;font-weight:600;border-left:3px solid #4f6ef7;">Ulasan Saya</a>
            <p class="text-xs font-semibold text-gray-400 px-3 mt-5 mb-2 uppercase tracking-wider">Akaun</p>
            <a href="{{ route('profil.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">Profil Saya</a>
            <form method="POST" action="{{ route('logout') }}"
                onsubmit="return confirm('Adakah anda pasti mahu log keluar?')">
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

    {{-- ==================== KANDUNGAN UTAMA ==================== --}}
    <main class="ml-56 flex-1 p-6">

        {{-- Topbar --}}
        <div class="mb-6">
            <h1 class="text-lg font-bold text-gray-800">Ulasan & Penilaian</h1>
            <p class="text-sm text-gray-400 mt-0.5">Kongsikan pendapat anda tentang peranti audio</p>
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

        <div class="grid grid-cols-2 gap-5">

            {{-- ==================== BORANG ULASAN ==================== --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-5">
                <h2 class="text-sm font-bold text-gray-700 mb-4">Tulis Ulasan Baru</h2>

                {{-- Pilih Peranti --}}
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 mb-2">Pilih Peranti Audio</label>
                    <select id="perantiSelect" name="id_peranti"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        onchange="updatePeranti(this)">
                        <option value="">-- Pilih peranti --</option>
                        @foreach($senaraiPeranti ?? [] as $peranti)
                        <option value="{{ $peranti->id }}"
                            data-nama="{{ $peranti->nama }}"
                            data-jenama="{{ $peranti->jenama }}"
                            data-kategori="{{ $peranti->kategori->nama_kategori ?? '-' }}"
                            data-harga="{{ number_format($peranti->harga, 2) }}">
                            {{ $peranti->nama }} — RM {{ number_format($peranti->harga, 2) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Info Peranti Terpilih --}}
                <div id="perantiInfo" class="hidden mb-4 bg-gray-50 rounded-xl p-4 flex gap-3 items-center border border-gray-100">
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-2xl">🎧</div>
                    <div>
                        <p id="perantiNama" class="text-sm font-bold text-gray-800"></p>
                        <p id="perantiBrand" class="text-xs text-gray-400"></p>
                        <p id="perantiHarga" class="text-sm font-bold text-blue-600 mt-0.5"></p>
                    </div>
                </div>

                {{-- Borang --}}
                <form method="POST" action="{{ route('ulasan.simpan') }}">
                    @csrf
                    <input type="hidden" name="id_peranti" id="hiddenPeranti">

                    {{-- Rating Bintang --}}
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-gray-500 mb-2">Penilaian Anda</label>
                        <div class="flex gap-2" id="starContainer">
                            <span class="star" data-val="1" onclick="setRating(1)">★</span>
                            <span class="star" data-val="2" onclick="setRating(2)">★</span>
                            <span class="star" data-val="3" onclick="setRating(3)">★</span>
                            <span class="star" data-val="4" onclick="setRating(4)">★</span>
                            <span class="star" data-val="5" onclick="setRating(5)">★</span>
                        </div>
                        <p id="ratingLabel" class="text-xs text-gray-400 mt-1">Klik bintang untuk beri penilaian</p>
                        <input type="hidden" name="penilaian" id="ratingInput" value="0">
                    </div>

                    {{-- Komen --}}
                    <div class="mb-5">
                        <label class="block text-xs font-semibold text-gray-500 mb-2">Komen Anda</label>
                        <textarea
                            name="komen"
                            rows="4"
                            placeholder="Tulis pengalaman anda menggunakan peranti ini..."
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-200 resize-none">{{ old('komen') }}</textarea>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-3 rounded-xl transition">
                        Hantar Ulasan
                    </button>
                </form>
            </div>

            {{-- ==================== SENARAI ULASAN ==================== --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-gray-700">Ulasan Terkini</h2>
                    <span class="text-xs font-semibold bg-blue-50 text-blue-600 px-3 py-1 rounded-full">
                        {{ count($ulasan ?? []) }} Ulasan
                    </span>
                </div>

                @forelse($ulasan ?? [] as $u)
                <div class="flex gap-3 py-4 border-b border-gray-50 last:border-0">

                    {{-- Avatar --}}
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold uppercase flex-shrink-0"
                        style="background:#eef0fe;color:#4f6ef7;">
                        {{ strtoupper(substr($u->pengguna->nama ?? 'U', 0, 2)) }}
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-700">{{ $u->pengguna->nama ?? 'Pengguna' }}</span>
                                <span class="text-xs text-gray-300 ml-2">{{ $u->tarikh ? \Carbon\Carbon::parse($u->tarikh)->diffForHumans() : '-' }}</span>
                            </div>
                            {{-- Padam (kalau ulasan sendiri) --}}
                            @if(auth()->id() === $u->id_pengguna)
                            <form method="POST" action="{{ route('ulasan.padam', $u->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-400 hover:text-red-600 transition">Padam</button>
                            </form>
                            @endif
                        </div>

                        {{-- Bintang --}}
                        <div class="flex gap-0.5 my-1">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="text-sm {{ $i <= $u->penilaian ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                                @endfor
                        </div>

                        {{-- Nama Peranti --}}
                        <a href="{{ route('peranti.detail', $u->peranti->id ?? 0) }}"
                            class="text-xs text-blue-500 font-semibold mb-1 hover:underline">
                            {{ $u->peranti->nama ?? '-' }}
                        </a>

                        {{-- Komen --}}
                        <p class="text-xs text-gray-500 leading-relaxed">{{ $u->komen ?? 'Tiada komen.' }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-10">
                    <p class="text-sm text-gray-400">Belum ada ulasan lagi.</p>
                    <p class="text-xs text-gray-300 mt-1">Jadilah yang pertama memberi ulasan!</p>
                </div>
                @endforelse

            </div>
        </div>

    </main>

</body>

<script>
    // Rating bintang
    const labels = ['', '1 bintang — Teruk', '2 bintang — Kurang Memuaskan', '3 bintang — Okay', '4 bintang — Bagus', '5 bintang — Cemerlang!'];
    let currentRating = 0;

    function setRating(val) {
        currentRating = val;
        document.getElementById('ratingInput').value = val;
        document.getElementById('ratingLabel').textContent = labels[val];
        document.querySelectorAll('.star').forEach((s, i) => {
            s.classList.toggle('active', i < val);
        });
    }

    // Hover effect
    document.querySelectorAll('.star').forEach((star, i) => {
        star.addEventListener('mouseover', () => {
            document.querySelectorAll('.star').forEach((s, j) => {
                s.classList.toggle('active', j <= i);
            });
        });
        star.addEventListener('mouseout', () => {
            document.querySelectorAll('.star').forEach((s, j) => {
                s.classList.toggle('active', j < currentRating);
            });
        });
    });

    // Update info peranti bila pilih dropdown
    function updatePeranti(select) {
        const option = select.options[select.selectedIndex];
        const info = document.getElementById('perantiInfo');
        if (select.value) {
            document.getElementById('perantiNama').textContent = option.dataset.nama;
            document.getElementById('perantiBrand').textContent = option.dataset.jenama + ' • ' + option.dataset.kategori;
            document.getElementById('perantiHarga').textContent = 'RM ' + option.dataset.harga;
            document.getElementById('hiddenPeranti').value = select.value;
            info.classList.remove('hidden');
        } else {
            info.classList.add('hidden');
        }
    }
</script>

</html>