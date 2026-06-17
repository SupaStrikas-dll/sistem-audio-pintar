<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borang Keutamaan Audio - Sistem Cadangan Audio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .option-card {
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.15s;
        }

        .option-card:hover {
            border-color: #4f6ef7;
            background: #f8f9ff;
        }

        .option-card.selected {
            border-color: #4f6ef7;
            background: #eef0fe;
            color: #4f6ef7;
            font-weight: 600;
        }

        .step-content {
            display: none;
        }

        .step-content.active {
            display: block;
        }

        input[type=range] {
            accent-color: #4f6ef7;
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
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm mb-1" style="background:#eef0fe;color:#4f6ef7;font-weight:600;border-left:3px solid #4f6ef7;">Cadangan Baru</a>
            <a href="{{ route('sejarah.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">Sejarah Cadangan</a>
            <a href="{{ route('ulasan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:bg-gray-50 mb-1 transition">Ulasan Saya</a>
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

    {{-- Popup Amaran --}}
    <div id="popup-amaran" class="hidden fixed top-6 left-1/2 -translate-x-1/2 z-50">
        <div class="bg-red-50 border border-red-200 text-red-600 text-sm font-semibold px-6 py-3.5 rounded-2xl shadow-lg flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z" />
            </svg>
            <span id="popup-mesej"></span>
        </div>
    </div>

    {{-- ==================== KANDUNGAN UTAMA ==================== --}}
    <main class="ml-56 flex-1 p-6 flex items-center justify-center">
        <div class="w-full max-w-xl">

            {{-- Tajuk --}}
            <div class="text-center mb-6">
                <h1 class="text-xl font-bold text-gray-800">Borang Keutamaan Audio</h1>
                <p class="text-sm text-gray-400 mt-1">Jawab soalan di bawah untuk mendapatkan cadangan terbaik</p>
            </div>

            {{-- Kad Borang --}}
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">

                {{-- Progress Bar --}}
                <div class="h-1 bg-gray-100">
                    <div id="progressBar" class="h-1 bg-blue-500 rounded-r-full transition-all duration-300" style="width: 33%"></div>
                </div>

                {{-- Step Indicator --}}
                <div class="px-6 pt-5 pb-4 border-b border-gray-100">
                    <div class="flex items-center justify-between mb-4">

                        {{-- Step 1 --}}
                        <div class="flex items-center gap-2">
                            <div id="step1-num" class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold bg-green-100 text-green-600">✓</div>
                            <span id="step1-label" class="text-xs text-gray-400">Jenis Peranti</span>
                        </div>

                        <div id="line1" class="flex-1 h-px bg-blue-400 mx-3"></div>

                        {{-- Step 2 --}}
                        <div class="flex items-center gap-2">
                            <div id="step2-num" class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold bg-blue-600 text-white">2</div>
                            <span id="step2-label" class="text-xs text-blue-600 font-semibold">Bajet & Guna</span>
                        </div>

                        <div id="line2" class="flex-1 h-px bg-gray-200 mx-3"></div>

                        {{-- Step 3 --}}
                        <div class="flex items-center gap-2">
                            <div id="step3-num" class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold bg-gray-100 text-gray-400">3</div>
                            <span id="step3-label" class="text-xs text-gray-400">Sambungan</span>
                        </div>

                    </div>

                    <h2 id="stepTitle" class="text-base font-bold text-gray-800">Bajet & Kegunaan</h2>
                    <p id="stepSub" class="text-xs text-gray-400 mt-0.5">Tetapkan bajet dan kegunaan utama anda</p>
                </div>

                {{-- Borang --}}
                <form method="POST" action="{{ route('keutamaan.simpan') }}" id="mainForm">
                    @csrf

                    <div class="px-6 py-5">

                        {{-- ========== STEP 1 — Jenis Peranti ========== --}}
                        <div class="step-content active" id="tab1">
                            <label class="block text-sm font-semibold text-gray-600 mb-3">Pilih Jenis Peranti Audio</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="option-card">
                                    <input type="radio" name="jenis" value="Fon Telinga" class="hidden" required>
                                    <span class="text-sm">Fon Telinga</span>
                                </label>
                                <label class="option-card">
                                    <input type="radio" name="jenis" value="Speaker" class="hidden">
                                    <span class="text-sm">Speaker</span>
                                </label>
                                <label class="option-card">
                                    <input type="radio" name="jenis" value="Mikrofon" class="hidden">
                                    <span class="text-sm">Mikrofon</span>
                                </label>
                                <label class="option-card">
                                    <input type="radio" name="jenis" value="Earphone" class="hidden">
                                    <span class="text-sm">Earphone</span>
                                </label>
                            </div>
                        </div>

                        {{-- ========== STEP 2 — Bajet & Kegunaan ========== --}}
                        <div class="step-content" id="tab2">

                            <label class="block text-sm font-semibold text-gray-600 mb-3">Julat Bajet (RM)</label>
                            <div class="bg-gray-50 rounded-xl p-4 mb-5">
                                <div class="flex justify-between text-xs text-gray-400 mb-2">
                                    <span>RM 50</span>
                                    <span>RM 5,000</span>
                                </div>
                                <input type="range" name="bajet" min="50" max="5000" value="500" step="50"
                                    class="w-full"
                                    oninput="document.getElementById('bajetVal').textContent = 'RM ' + parseInt(this.value).toLocaleString()">
                                <div class="text-center mt-2">
                                    <span id="bajetVal" class="text-lg font-bold text-blue-600">RM 500</span>
                                </div>
                            </div>

                            <label class="block text-sm font-semibold text-gray-600 mb-3">Kegunaan Utama</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="option-card">
                                    <input type="radio" name="kegunaan" value="Gaming" class="hidden" required>
                                    <span class="text-sm">Gaming</span>
                                </label>
                                <label class="option-card">
                                    <input type="radio" name="kegunaan" value="Muzik" class="hidden">
                                    <span class="text-sm">Muzik</span>
                                </label>
                                <label class="option-card">
                                    <input type="radio" name="kegunaan" value="Kerja" class="hidden">
                                    <span class="text-sm">Kerja/Mesyuarat</span>
                                </label>
                                <label class="option-card">
                                    <input type="radio" name="kegunaan" value="Studio" class="hidden">
                                    <span class="text-sm">Studio/Rakaman</span>
                                </label>
                            </div>
                        </div>

                        {{-- ========== STEP 3 — Sambungan & Jenama ========== --}}
                        <div class="step-content" id="tab3">

                            <label class="block text-sm font-semibold text-gray-600 mb-3">Jenis Sambungan</label>
                            <div class="grid grid-cols-2 gap-3 mb-5">
                                <label class="option-card">
                                    <input type="radio" name="sambungan" value="Wayar" class="hidden" required>
                                    <span class="text-sm">Wayar</span>
                                </label>
                                <label class="option-card">
                                    <input type="radio" name="sambungan" value="Wayarles" class="hidden">
                                    <span class="text-sm">Tanpa Wayar</span>
                                </label>
                                <label class="option-card">
                                    <input type="radio" name="sambungan" value="Bluetooth" class="hidden">
                                    <span class="text-sm">Bluetooth</span>
                                </label>
                                <label class="option-card">
                                    <input type="radio" name="sambungan" value="Semua" class="hidden">
                                    <span class="text-sm">Semua Jenis</span>
                                </label>
                            </div>

                            
                            </div>
                        </div>

                    </div>

                    {{-- Footer Butang --}}
                    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                        <button type="button" onclick="prevStep()"
                            id="prevBtn"
                            class="text-sm font-semibold text-gray-400 border border-gray-200 px-5 py-2.5 rounded-xl hover:bg-gray-50 transition invisible">
                            Sebelum
                        </button>
                        <span id="stepCount" class="text-xs text-gray-400">Langkah 1 / 3</span>
                        <button type="button" onclick="nextStep()"
                            id="nextBtn"
                            class="text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-5 py-2.5 rounded-xl transition">
                            Seterusnya
                        </button>
                        <button type="submit"
                            id="submitBtn"
                            class="text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-5 py-2.5 rounded-xl transition hidden">
                            Dapatkan Cadangan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </main>

</body>

<script>
    let currentStep = 1;
    const totalSteps = 3;

    const titles = ['Jenis Peranti', 'Bajet & Kegunaan', 'Sambungan & Jenama'];
    const subs = [
        'Pilih jenis peranti audio yang anda cari',
        'Tetapkan bajet dan kegunaan utama anda',
        'Pilih jenis sambungan dan jenama pilihan'
    ];

    // Option card click handler
    document.querySelectorAll('.option-card').forEach(card => {
        card.addEventListener('click', function() {
            const radio = this.querySelector('input[type=radio]');
            if (radio) {
                radio.checked = true;
                // Deselect siblings
                const name = radio.name;
                document.querySelectorAll(`input[name="${name}"]`).forEach(r => {
                    r.closest('.option-card').classList.remove('selected');
                });
                this.classList.add('selected');
            }
        });
    });

    function updateUI() {
        // Update tabs
        for (let i = 1; i <= totalSteps; i++) {
            document.getElementById('tab' + i).classList.toggle('active', i === currentStep);

            const num = document.getElementById('step' + i + '-num');
            const label = document.getElementById('step' + i + '-label');

            if (i < currentStep) {
                num.className = 'w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold bg-green-100 text-green-600';
                num.textContent = '✓';
                label.className = 'text-xs text-gray-400';
            } else if (i === currentStep) {
                num.className = 'w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold bg-blue-600 text-white';
                num.textContent = i;
                label.className = 'text-xs text-blue-600 font-semibold';
            } else {
                num.className = 'w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold bg-gray-100 text-gray-400';
                num.textContent = i;
                label.className = 'text-xs text-gray-400';
            }
        }

        // Update lines
        for (let i = 1; i < totalSteps; i++) {
            const line = document.getElementById('line' + i);
            line.className = 'flex-1 h-px mx-3 ' + (i < currentStep ? 'bg-blue-400' : 'bg-gray-200');
        }

        // Update title & sub
        document.getElementById('stepTitle').textContent = titles[currentStep - 1];
        document.getElementById('stepSub').textContent = subs[currentStep - 1];
        document.getElementById('stepCount').textContent = 'Langkah ' + currentStep + ' / ' + totalSteps;

        // Update progress bar
        document.getElementById('progressBar').style.width = (currentStep / totalSteps * 100) + '%';

        // Update buttons
        document.getElementById('prevBtn').classList.toggle('invisible', currentStep === 1);
        document.getElementById('nextBtn').classList.toggle('hidden', currentStep === totalSteps);
        document.getElementById('submitBtn').classList.toggle('hidden', currentStep !== totalSteps);
    }

    // Mesej popup
    function tunjukPopup(mesej) {
        const popup = document.getElementById('popup-amaran');
        const popupMesej = document.getElementById('popup-mesej');
        popupMesej.textContent = mesej;
        popup.classList.remove('hidden');
        setTimeout(() => popup.classList.add('hidden'), 3000);
    }

    // Semak pilihan sebelum next
    function semakPilihan() {
        if (currentStep === 1) {
            const terpilih = document.querySelector('input[name="jenis"]:checked');
            if (!terpilih) {
                tunjukPopup('Sila pilih jenis peranti audio terlebih dahulu.');
                return false;
            }
        }
        if (currentStep === 2) {
            const kegunaan = document.querySelector('input[name="kegunaan"]:checked');
            if (!kegunaan) {
                tunjukPopup('Sila pilih kegunaan utama peranti anda.');
                return false;
            }
        }
        if (currentStep === 3) {
            const sambungan = document.querySelector('input[name="sambungan"]:checked');
            if (!sambungan) {
                tunjukPopup('Sila pilih jenis sambungan peranti anda.');
                return false;
            }
        }
        return true;
    }

    function nextStep() {
        if (!semakPilihan()) return;
        if (currentStep < totalSteps) {
            currentStep++;
            updateUI();
            window.scrollTo(0, 0);
        }
    }

    function prevStep() {
        if (currentStep > 1) {
            currentStep--;
            updateUI();
            window.scrollTo(0, 0);
        }
    }
</script>

</html>