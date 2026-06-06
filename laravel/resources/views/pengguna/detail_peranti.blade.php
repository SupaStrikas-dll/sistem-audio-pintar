<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $peranti->nama }} - Detail Peranti</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .zone-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 100px; font-size: 11px; font-weight: 600; cursor: pointer; transition: all 0.15s; border: 1.5px solid transparent; }
        .zone-badge.active { opacity: 1; }
        .zone-badge.inactive { opacity: 0.4; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex">

    {{-- ==================== SIDEBAR ==================== --}}
    <aside class="w-56 bg-white border-r border-gray-100 min-h-screen flex flex-col fixed left-0 top-0 z-40">
        <div class="px-5 py-5 border-b border-gray-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24"><path d="M12 3a9 9 0 0 0-9 9 9 9 0 0 0 9 9 9 9 0 0 0 9-9 9 9 0 0 0-9-9zm0 2a7 7 0 0 1 7 7 7 7 0 0 1-7 7A7 7 0 0 1 5 12 7 7 0 0 1 12 5zm0 2a5 5 0 0 0-5 5 5 5 0 0 0 5 5 5 5 0 0 0 5-5 5 5 0 0 0-5-5zm0 2a3 3 0 0 1 3 3 3 3 0 0 1-3 3 3 3 0 0 1-3-3 3 3 0 0 1 3-3z"/></svg>
                </div>
                <span class="text-sm font-bold">Audio<span class="text-blue-600">Pintar</span></span>
            </div>
        </div>
        <nav class="flex-1 py-4 px-3">
            <p class="text-xs font-semibold text-gray-400 px-3 mb-2 uppercase tracking-wider">Menu Utama</p>
            <a href="{{ route('pengguna.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">Dashboard</a>
            <a href="{{ route('keutamaan.borang') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm mb-1" style="background:#eef0fe;color:#4f6ef7;font-weight:600;border-left:3px solid #4f6ef7;">Cadangan Baru</a>
            <a href="{{ route('sejarah.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">Sejarah Cadangan</a>
            <a href="{{ route('ulasan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">Ulasan Saya</a>
            <p class="text-xs font-semibold text-gray-400 px-3 mt-5 mb-2 uppercase tracking-wider">Akaun</p>
            <a href="{{ route('profil.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">Profil Saya</a>
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

    {{-- ==================== KANDUNGAN UTAMA ==================== --}}
    <main class="ml-56 flex-1 p-6">

        <div class="mb-5">
            <a href="javascript:history.back()" class="text-sm text-gray-500 hover:text-blue-600 transition">
                ← Kembali ke Cadangan
            </a>
        </div>

        <div class="grid grid-cols-3 gap-5">

            {{-- ==================== MAKLUMAT PERANTI ==================== --}}
            <div class="col-span-1 space-y-4">

                <div class="bg-white border border-gray-100 rounded-2xl p-5">

                    {{-- Gambar --}}
                    @if($peranti->imej)
                        <img src="{{ asset($peranti->imej) }}"
                             alt="{{ $peranti->nama }}"
                             class="w-full h-44 object-cover rounded-xl mb-5">
                    @else
                        <div class="w-full h-44 rounded-xl flex items-center justify-center text-6xl mb-5"
                             style="background: {{ ($peranti->kategori->nama_kategori ?? '') === 'Speaker' ? '#f3eeff' : (($peranti->kategori->nama_kategori ?? '') === 'Mikrofon' ? '#edfdf5' : '#eef0fe') }}">
                            @if(($peranti->kategori->nama_kategori ?? '') === 'Speaker') 🔊
                            @elseif(($peranti->kategori->nama_kategori ?? '') === 'Mikrofon') 🎤
                            @elseif(($peranti->kategori->nama_kategori ?? '') === 'Earphone') 🎵
                            @else 🎧
                            @endif
                        </div>
                    @endif

                    <h1 class="text-base font-bold text-gray-800 mb-1">{{ $peranti->nama }}</h1>
                    <p class="text-sm text-gray-400 mb-3">{{ $peranti->jenama }} • {{ $peranti->kategori->nama_kategori ?? '-' }}</p>
                    <p class="text-2xl font-bold text-blue-600 mb-4">RM {{ number_format($peranti->harga, 2) }}</p>

                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="text-base {{ $i <= round($peranti->skor_purata ?? 0) ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-500">{{ number_format($peranti->skor_purata ?? 0, 1) }} / 5.0</span>
                    </div>

                    <div class="border-t border-gray-100 pt-4 space-y-2.5">
                        @if($peranti->julat_frekuensi)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Julat Frekuensi</span>
                                <span class="font-semibold text-gray-700">{{ $peranti->julat_frekuensi }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Status</span>
                            <span class="font-semibold {{ $peranti->status ? 'text-green-600' : 'text-red-500' }}">
                                {{ $peranti->status ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($peranti->penerangan)
                    <div class="bg-white border border-gray-100 rounded-2xl p-5">
                        <h3 class="text-sm font-bold text-gray-700 mb-3">Penerangan</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">{{ $peranti->penerangan }}</p>
                    </div>
                @endif

            </div>

            {{-- ==================== GRAF & ULASAN ==================== --}}
            <div class="col-span-2 space-y-5">

                {{-- Graf Frekuensi --}}
                @if(in_array($peranti->kategori->nama_kategori ?? '', ['Fon Telinga', 'Earphone']) && $peranti->data_frekuensi)
                    <div class="bg-white border border-gray-100 rounded-2xl p-5">

                        {{-- Header Graf --}}
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h2 class="text-sm font-bold text-gray-700">Graf Tindak Balas Frekuensi</h2>
                                <p class="text-xs text-gray-400 mt-0.5">Tahap desibel (dB) pada setiap frekuensi (Hz)</p>
                            </div>
                            @if($peranti->julat_frekuensi)
                                <span class="text-xs font-semibold bg-blue-50 text-blue-600 px-3 py-1 rounded-full">
                                    {{ $peranti->julat_frekuensi }}
                                </span>
                            @endif
                        </div>

                        {{-- Zon Badge Toggle --}}
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-xs text-gray-400 mr-1">Zon:</span>
                            <button onclick="toggleZon('bass')" id="badge-bass"
                                class="zone-badge active"
                                style="background:#fff1f2;color:#ef4444;border-color:#fecaca;">
                                <span class="w-2 h-2 rounded-full bg-red-400"></span> Bass
                            </button>
                            <button onclick="toggleZon('mid')" id="badge-mid"
                                class="zone-badge active"
                                style="background:#f0fdf4;color:#22c55e;border-color:#bbf7d0;">
                                <span class="w-2 h-2 rounded-full bg-green-400"></span> Mid
                            </button>
                            <button onclick="toggleZon('treble')" id="badge-treble"
                                class="zone-badge active"
                                style="background:#eff6ff;color:#3b82f6;border-color:#bfdbfe;">
                                <span class="w-2 h-2 rounded-full bg-blue-400"></span> Treble
                            </button>
                        </div>

                        {{-- Penerangan Zon --}}
                        <div id="zon-info" class="mb-4 text-xs text-gray-400 bg-gray-50 rounded-xl px-4 py-2.5 hidden">
                            <span id="zon-info-text"></span>
                        </div>

                        {{-- Canvas Graf --}}
                        <div class="relative h-64">
                            <canvas id="grafFrekuensi"></canvas>
                        </div>

                        {{-- Legenda Zon --}}
                        <div class="mt-4 grid grid-cols-3 gap-3">
                            <div class="bg-red-50 rounded-xl p-3 text-center">
                                <p class="text-xs font-bold text-red-500 mb-0.5">Bass</p>
                                <p class="text-xs text-red-400">20Hz – 250Hz</p>
                                <p class="text-xs text-gray-400 mt-1">Rendah & Dalam</p>
                            </div>
                            <div class="bg-green-50 rounded-xl p-3 text-center">
                                <p class="text-xs font-bold text-green-500 mb-0.5">Mid</p>
                                <p class="text-xs text-green-400">250Hz – 4kHz</p>
                                <p class="text-xs text-gray-400 mt-1">Vokal & Instrumen</p>
                            </div>
                            <div class="bg-blue-50 rounded-xl p-3 text-center">
                                <p class="text-xs font-bold text-blue-500 mb-0.5">Treble</p>
                                <p class="text-xs text-blue-400">4kHz – 20kHz</p>
                                <p class="text-xs text-gray-400 mt-1">Tinggi & Jernih</p>
                            </div>
                        </div>

                    </div>
                @endif

                {{-- Ulasan --}}
                <div class="bg-white border border-gray-100 rounded-2xl p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-sm font-bold text-gray-700">Ulasan Pengguna</h2>
                        <span class="text-xs font-semibold bg-blue-50 text-blue-600 px-3 py-1 rounded-full">
                            {{ $peranti->ulasan->count() }} Ulasan
                        </span>
                    </div>

                    @forelse($peranti->ulasan as $u)
                        <div class="flex gap-3 py-4 border-b border-gray-50 last:border-0">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold uppercase flex-shrink-0"
                                 style="background:#eef0fe;color:#4f6ef7;">
                                {{ strtoupper(substr($u->pengguna->nama ?? 'U', 0, 2)) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-semibold text-gray-700">{{ $u->pengguna->nama ?? 'Pengguna' }}</span>
                                    <span class="text-xs text-gray-300">{{ \Carbon\Carbon::parse($u->tarikh)->diffForHumans() }}</span>
                                </div>
                                <div class="flex gap-0.5 my-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="text-sm {{ $i <= $u->penilaian ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                                    @endfor
                                </div>
                                <p class="text-xs text-gray-500 leading-relaxed">{{ $u->komen ?? 'Tiada komen.' }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <p class="text-sm text-gray-400">Belum ada ulasan untuk peranti ini.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>

    </main>

</body>

@if(in_array($peranti->kategori->nama_kategori ?? '', ['Fon Telinga', 'Earphone']) && $peranti->data_frekuensi)
<script>
    const dataFrekuensi = @json(json_decode($peranti->data_frekuensi));
    const labelFrekuensi = ['20Hz', '50Hz', '100Hz', '200Hz', '500Hz', '1kHz', '2kHz', '5kHz', '10kHz', '20kHz'];

    // Status zon (aktif/tidak)
    const zonStatus = { bass: true, mid: true, treble: true };

    // Maklumat zon
    const zonInfo = {
        bass: 'Bass (20Hz – 250Hz): Bunyi rendah seperti dram dan bas gitar. Lebih tinggi nilai dB, lebih kuat bass.',
        mid: 'Mid (250Hz – 4kHz): Julat vokal dan instrumen utama. Penting untuk kejelasan bunyi.',
        treble: 'Treble (4kHz – 20kHz): Bunyi tinggi seperti simbal dan melodi. Memberi kecerahan pada audio.'
    };

    // Plugin zon warna latar
    const backgroundZonesPlugin = {
        id: 'backgroundZones',
        beforeDraw(chart) {
            const { ctx, chartArea: { left, right, top, bottom }, scales: { x } } = chart;

            const zones = [
                { id: 'bass',   startIdx: 0, endIdx: 3, color: 'rgba(239, 68, 68, 0.07)',  label: 'Bass',   textColor: '#ef4444' },
                { id: 'mid',    startIdx: 3, endIdx: 6, color: 'rgba(34, 197, 94, 0.07)',  label: 'Mid',    textColor: '#22c55e' },
                { id: 'treble', startIdx: 6, endIdx: 9, color: 'rgba(59, 130, 246, 0.07)', label: 'Treble', textColor: '#3b82f6' },
            ];

            zones.forEach(zone => {
                if (!zonStatus[zone.id]) return;

                const startX = x.getPixelForValue(zone.startIdx);
                const endX   = x.getPixelForValue(zone.endIdx);

                ctx.save();

                // Warna latar zon
                ctx.fillStyle = zone.color;
                ctx.fillRect(startX, top, endX - startX, bottom - top);

                // Label zon
                ctx.fillStyle = zone.textColor;
                ctx.font = 'bold 10px Plus Jakarta Sans';
                ctx.textAlign = 'center';
                ctx.globalAlpha = 0.6;
                ctx.fillText(zone.label, (startX + endX) / 2, top + 14);

                ctx.restore();
            });
        }
    };

    const ctx = document.getElementById('grafFrekuensi').getContext('2d');

    const graf = new Chart(ctx, {
        type: 'line',
        plugins: [backgroundZonesPlugin],
        data: {
            labels: labelFrekuensi,
            datasets: [{
                label: '{{ $peranti->nama }}',
                data: dataFrekuensi,
                borderColor: '#4f6ef7',
                backgroundColor: 'rgba(79, 110, 247, 0.06)',
                borderWidth: 2.5,
                pointBackgroundColor: '#4f6ef7',
                pointRadius: 4,
                pointHoverRadius: 7,
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#4f6ef7',
                pointHoverBorderWidth: 2,
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e1b4b',
                    titleColor: '#a5b4fc',
                    bodyColor: '#ffffff',
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        title(items) {
                            const idx = items[0].dataIndex;
                            const zon = idx <= 3 ? 'Zon Bass' : idx <= 6 ? 'Zon Mid' : 'Zon Treble';
                            return `${labelFrekuensi[idx]}  •  ${zon}`;
                        },
                        label(item) {
                            return `  ${item.parsed.y} dB`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: { font: { size: 11, family: 'Plus Jakarta Sans' }, color: '#9ca3af' }
                },
                y: {
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: {
                        font: { size: 11, family: 'Plus Jakarta Sans' },
                        color: '#9ca3af',
                        callback: v => v + ' dB'
                    }
                }
            },
            onHover(event, elements) {
                if (elements.length > 0) {
                    const idx = elements[0].index;
                    const zonId = idx <= 3 ? 'bass' : idx <= 6 ? 'mid' : 'treble';
                    const info = document.getElementById('zon-info');
                    const infoText = document.getElementById('zon-info-text');
                    info.classList.remove('hidden');
                    infoText.textContent = zonInfo[zonId];
                }
            }
        }
    });

    // Toggle zon
    function toggleZon(zonId) {
        zonStatus[zonId] = !zonStatus[zonId];
        const badge = document.getElementById('badge-' + zonId);
        badge.classList.toggle('active', zonStatus[zonId]);
        badge.classList.toggle('inactive', !zonStatus[zonId]);
        graf.update();
    }
</script>
@endif

</html>