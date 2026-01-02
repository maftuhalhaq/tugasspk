<!DOCTYPE html>
<html lang="id">

<head>
    <title>Ultimate SPK Engine - BAMN AMORE Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f1f5f9;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Slider */
        input[type=range] {
            -webkit-appearance: none;
            width: 100%;
            background: transparent;
        }

        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 24px;
            width: 24px;
            border-radius: 50%;
            background: #fff;
            border: 4px solid #f43f5e;
            cursor: pointer;
            margin-top: -10px;
            box-shadow: 0 4px 6px -1px rgba(244, 63, 94, 0.3);
            transition: transform 0.2s;
        }

        input[type=range]::-webkit-slider-thumb:hover {
            transform: scale(1.15);
            border-color: #e11d48;
        }

        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 6px;
            cursor: pointer;
            background: #e2e8f0;
            border-radius: 99px;
        }

        /* Inputs */
        .pro-input {
            width: 100%;
            background-color: #fff;
            border: 1px solid #cbd5e1;
            color: #334155;
            padding: 0.5rem 0.75rem;
            border-radius: 0.75rem;
            font-weight: 700;
            font-size: 0.85rem;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .pro-input:focus {
            border-color: #f43f5e;
            outline: none;
            box-shadow: 0 0 0 3px rgba(244, 63, 94, 0.1);
        }

        .pro-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 800;
            color: #94a3b8;
            margin-bottom: 0.25rem;
            display: block;
        }

        .hover-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .battle-card {
            position: relative;
            overflow: hidden;
        }

        .battle-vs {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            background: #fff;
            padding: 0.5rem;
            border-radius: 50%;
            font-weight: 900;
            color: #cbd5e1;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Detail Table */
        .calc-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.65rem;
            padding: 2px 0;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
        }

        .calc-row:last-child {
            border-bottom: none;
        }

        .calc-label {
            color: #94a3b8;
        }

        .calc-val {
            font-family: monospace;
            color: #e2e8f0;
        }

        .calc-highlight {
            color: #facc15;
            font-weight: bold;
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-slate-800">

    <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col z-30 shadow-lg">
        <div class="h-20 flex items-center px-8 border-b border-slate-50">
            <span class="text-3xl mr-2">💘</span>
            <span class="font-black text-xl tracking-tight text-slate-800">BAMN AMORE <span
                    class="text-rose-500">Admin</span></span>
        </div>
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 mt-2">Menu Utama</p>
            <a href="/admin/dashboard"
                class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-rose-50 hover:text-rose-600 rounded-xl font-bold transition">
                <i class="fa-solid fa-chart-pie w-6 text-center"></i> Dashboard
            </a>
            <a href="/admin/users"
                class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-rose-50 hover:text-rose-600 rounded-xl font-bold transition">
                <i class="fa-solid fa-users w-6 text-center"></i> User Manager
            </a>
            <div class="my-4 border-t border-slate-100"></div>
            <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">System Core</p>
            <a href="/admin/weights"
                class="flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-rose-500 to-pink-600 text-white rounded-xl font-bold transition shadow-md shadow-rose-200">
                <i class="fa-solid fa-sliders w-6 text-center"></i> SPK Engine
            </a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden bg-slate-50 relative">
        <main class="flex-1 overflow-y-auto p-6 md:p-8 relative z-10 scroll-smooth">

            <div
                class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4 bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                <div>
                    <h1 class="text-3xl font-black text-slate-800 tracking-tight">System Logic Control</h1>
                    <p class="text-slate-500 font-medium text-sm mt-1 max-w-xl">
                        Pusat kendali algoritma SPK. Atur bobot, toleransi, dan lihat detail perhitungannya.
                    </p>
                </div>
                <div class="flex gap-3">
                    <form action="{{ route('admin.weights.reset') }}" method="POST"
                        onsubmit="return confirm('⚠️ Reset ke default?')">
                        @csrf
                        <button
                            class="bg-slate-100 border border-slate-200 text-slate-500 px-5 py-3 rounded-xl text-xs font-bold hover:bg-slate-200 transition flex items-center gap-2">
                            <i class="fa-solid fa-rotate-left"></i> Reset
                        </button>
                    </form>
                    <button onclick="document.getElementById('mainForm').submit()"
                        class="bg-rose-500 text-white px-6 py-3 rounded-xl text-xs font-bold hover:bg-rose-600 shadow-xl shadow-rose-200 transition transform hover:-translate-y-1 flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk text-base"></i> SIMPAN
                    </button>
                </div>
            </div>

            <form action="/admin/weights" method="POST" id="mainForm">
                @csrf
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">

                    <div class="xl:col-span-7 space-y-8">

                        <div
                            class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 hover-card relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-rose-50 rounded-bl-full -z-0"></div>

                            <div class="flex justify-between items-center mb-8 relative z-10">
                                <div>
                                    <h3 class="font-bold text-xl text-slate-800 flex items-center gap-2">
                                        <span
                                            class="w-8 h-8 rounded-lg bg-rose-100 text-rose-500 flex items-center justify-center text-sm"><i
                                                class="fa-solid fa-sliders"></i></span>
                                        Bobot Prioritas (Slider)
                                    </h3>
                                    <p class="text-xs text-slate-400 mt-1">Pengali utama untuk setiap kriteria.</p>
                                </div>
                                <div class="bg-slate-900 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-lg"
                                    id="totalPercentBadge">
                                    Total: <span id="totalPercent">100%</span>
                                </div>
                            </div>

                            <div class="space-y-6 relative z-10">
                                @foreach ($criteriaWeights as $c)
                                    <div>
                                        <div class="flex justify-between text-xs font-bold text-slate-600 mb-2">
                                            <span class="flex items-center gap-2">
                                                <i class="fa-solid {{ $c->class_icon }} text-slate-400"></i>
                                                {{ $c->label }}
                                            </span>
                                            <span class="text-rose-500 font-black"><span
                                                    id="val-{{ $c->name }}">{{ $c->weight * 100 }}</span>%</span>
                                        </div>
                                        <input type="range" name="criteria[{{ $c->name }}]"
                                            id="slider-{{ $c->name }}" value="{{ $c->weight * 100 }}"
                                            min="0" max="100" step="5" class="criteria-slider"
                                            oninput="updateUI()">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 hover-card">
                            <h3 class="font-bold text-xl text-slate-800 mb-6 flex items-center gap-2">
                                <span
                                    class="w-8 h-8 rounded-lg bg-yellow-100 text-yellow-600 flex items-center justify-center text-sm"><i
                                        class="fa-solid fa-star"></i></span>
                                Setting Nilai Poin
                            </h3>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="space-y-2 p-3 bg-slate-50 rounded-2xl border border-slate-100">
                                    <label class="pro-label text-center">Agama Sama</label>
                                    <input type="number" step="0.1" name="points[rel_match]" id="inp-rel-match"
                                        value="{{ $points['rel_match'] }}" class="pro-input text-center text-green-600"
                                        oninput="updateUI()">
                                </div>
                                <div class="space-y-2 p-3 bg-slate-50 rounded-2xl border border-slate-100">
                                    <label class="pro-label text-center">Agama Beda</label>
                                    <input type="number" step="0.1" name="points[rel_mismatch]" id="inp-rel-miss"
                                        value="{{ $points['rel_mismatch'] }}" class="pro-input text-center text-red-600"
                                        oninput="updateUI()">
                                </div>
                                <div class="space-y-2 p-3 bg-slate-50 rounded-2xl border border-slate-100">
                                    <label class="pro-label text-center">Kota Sama</label>
                                    <input type="number" step="0.1" name="points[loc_match]" id="inp-loc-match"
                                        value="{{ $points['loc_match'] }}"
                                        class="pro-input text-center text-green-600" oninput="updateUI()">
                                </div>
                                <div class="space-y-2 p-3 bg-slate-50 rounded-2xl border border-slate-100">
                                    <label class="pro-label text-center">Kota Beda</label>
                                    <input type="number" step="0.1" name="points[loc_mismatch]"
                                        id="inp-loc-miss" value="{{ $points['loc_mismatch'] }}"
                                        class="pro-input text-center text-red-600" oninput="updateUI()">
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-slate-100 flex gap-4">
                                <div
                                    class="flex items-center gap-3 bg-blue-50/50 p-3 rounded-2xl border border-blue-100 flex-1">
                                    <div class="flex-1">
                                        <label class="pro-label text-blue-400">Bonus Kaya (+)</label>
                                        <p class="text-[9px] text-slate-400">Jika User > Target</p>
                                    </div>
                                    <input type="number" step="0.05" name="points[bonus_income]"
                                        id="inp-bonus-inc" value="{{ $points['bonus_income'] }}"
                                        class="pro-input w-20 text-center text-blue-600 border-blue-200"
                                        oninput="updateUI()">
                                </div>
                                <div
                                    class="flex items-center gap-3 bg-blue-50/50 p-3 rounded-2xl border border-blue-100 flex-1">
                                    <div class="flex-1">
                                        <label class="pro-label text-blue-400">Bonus Pintar (+)</label>
                                        <p class="text-[9px] text-slate-400">Jika User > Target</p>
                                    </div>
                                    <input type="number" step="0.05" name="points[bonus_edu]" id="inp-bonus-edu"
                                        value="{{ $points['bonus_edu'] }}"
                                        class="pro-input w-20 text-center text-blue-600 border-blue-200"
                                        oninput="updateUI()">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div
                                class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden hover-card">
                                <div class="p-6 bg-slate-50 border-b border-slate-100">
                                    <h3 class="font-bold text-slate-800 flex items-center gap-2 text-sm">
                                        <i class="fa-solid fa-money-bill-wave text-green-500"></i> Kamus Toleransi Gaji
                                    </h3>
                                </div>
                                <div class="p-4 space-y-3">
                                    <div class="flex text-[9px] text-slate-400 font-bold uppercase px-2">
                                        <div class="flex-1">Batas Selisih (Rp)</div>
                                        <div class="w-16 text-center">Poin</div>
                                    </div>
                                    @foreach ($incomeRanges as $idx => $range)
                                        <div class="flex gap-2 items-center">
                                            <div class="flex-1 relative">
                                                <span
                                                    class="absolute left-3 top-2.5 text-xs text-slate-400 font-bold">≤</span>
                                                <input type="number" name="income_range_limits[]"
                                                    value="{{ $range['limit'] }}" class="pro-input pl-8 text-xs"
                                                    id="inc-lim-{{ $idx }}" oninput="updateUI()">
                                            </div>
                                            <div class="w-16">
                                                <input type="number" step="0.1" name="income_range_weights[]"
                                                    value="{{ $range['weight'] }}"
                                                    class="pro-input text-center bg-green-50 text-green-700 border-green-200 text-xs"
                                                    id="inc-w-{{ $idx }}" oninput="updateUI()">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div
                                class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden hover-card">
                                <div class="p-6 bg-slate-50 border-b border-slate-100">
                                    <h3 class="font-bold text-slate-800 flex items-center gap-2 text-sm">
                                        <i class="fa-solid fa-graduation-cap text-blue-500"></i> Kamus GAP Pendidikan
                                    </h3>
                                </div>
                                <div class="p-4 space-y-3">
                                    <div class="flex text-[9px] text-slate-400 font-bold uppercase px-2">
                                        <div class="flex-1">Selisih Level</div>
                                        <div class="w-16 text-center">Poin</div>
                                    </div>
                                    @foreach ($gapWeights as $w)
                                        <div class="flex gap-2 items-center">
                                            <div
                                                class="flex-1 bg-slate-50 border border-slate-100 rounded-xl px-3 py-2 text-xs font-bold text-slate-600 flex justify-between items-center">
                                                <span>GAP {{ $w->gap }}</span>
                                                <span
                                                    class="text-[9px] font-normal text-slate-400">{{ $w->description }}</span>
                                            </div>
                                            <div class="w-16">
                                                <input type="number" step="0.1"
                                                    name="gap_weights[{{ $w->id }}]"
                                                    value="{{ $w->weight }}"
                                                    class="pro-input text-center text-blue-600 border-blue-100 text-xs"
                                                    id="gap-w-{{ $w->gap }}" oninput="updateUI()">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="xl:col-span-5 relative">
                        <div class="sticky top-6">

                            <div
                                class="bg-slate-900 rounded-[3rem] shadow-2xl p-6 text-white border border-slate-700 relative overflow-hidden">
                                <div
                                    class="absolute top-0 right-0 w-80 h-80 bg-rose-600 rounded-full blur-[100px] opacity-20 pointer-events-none animate-pulse">
                                </div>
                                <div
                                    class="absolute bottom-0 left-0 w-80 h-80 bg-blue-600 rounded-full blur-[100px] opacity-20 pointer-events-none animate-pulse">
                                </div>

                                <div class="relative z-10 text-center mb-6">
                                    <span
                                        class="bg-white/10 text-white px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border border-white/20">Live
                                        Simulation Lab</span>
                                    <h2 class="text-2xl font-black mt-2">Battle Arena <i
                                            class="fa-solid fa-flask text-yellow-400 ml-1"></i></h2>
                                    <p class="text-xs text-slate-400">Input data dummy untuk melihat detail hitungan.
                                    </p>
                                </div>

                                <div class="battle-card grid grid-cols-2 gap-3 mb-6">
                                    <div class="battle-vs text-xs">VS</div>

                                    <div
                                        class="bg-white/5 border border-white/10 rounded-3xl p-3 hover:bg-white/10 transition relative group">
                                        <div class="absolute top-0 left-0 w-full h-1 bg-blue-500 rounded-t-3xl"></div>
                                        <h4 class="text-center font-bold text-blue-400 text-xs mb-3">SKENARIO A</h4>

                                        <div class="space-y-2 mb-4">
                                            <input type="number" id="a-user-inc" value="5000000"
                                                class="pro-input bg-slate-800 border-slate-700 text-white focus:bg-slate-700 text-center text-xs px-1"
                                                oninput="updateUI()" placeholder="Gaji Saya">
                                            <input type="number" id="a-target-inc" value="5000000"
                                                class="pro-input bg-slate-800 border-slate-700 text-white focus:bg-slate-700 text-center text-xs px-1"
                                                oninput="updateUI()" placeholder="Gaji Target">
                                            <select id="a-rel"
                                                class="pro-input bg-slate-800 border-slate-700 text-white focus:bg-slate-700 text-xs px-1"
                                                onchange="updateUI()">
                                                <option value="match" selected>Agama Sama</option>
                                                <option value="mismatch">Agama Beda</option>
                                            </select>
                                            <select id="a-gap-edu"
                                                class="pro-input bg-slate-800 border-slate-700 text-white focus:bg-slate-700 text-xs px-1"
                                                onchange="updateUI()">
                                                <option value="0" selected>Edu Setara</option>
                                                <option value="1">Beda 1 Lvl</option>
                                                <option value="2">Beda 2 Lvl</option>
                                            </select>
                                        </div>

                                        <div class="bg-black/30 rounded-xl p-2 mb-2">
                                            <p
                                                class="text-[9px] text-slate-400 font-bold mb-1 text-center border-b border-white/10 pb-1">
                                                RINCIAN HITUNGAN</p>
                                            <div id="receipt-a" class="space-y-1">
                                            </div>
                                        </div>

                                        <div class="text-center pt-2 border-t border-white/10">
                                            <p class="text-2xl font-black text-white" id="score-a">0.00</p>
                                        </div>
                                    </div>

                                    <div
                                        class="bg-white/5 border border-white/10 rounded-3xl p-3 hover:bg-white/10 transition relative group">
                                        <div class="absolute top-0 left-0 w-full h-1 bg-yellow-500 rounded-t-3xl">
                                        </div>
                                        <h4 class="text-center font-bold text-yellow-400 text-xs mb-3">SKENARIO B</h4>

                                        <div class="space-y-2 mb-4">
                                            <input type="number" id="b-user-inc" value="3000000"
                                                class="pro-input bg-slate-800 border-slate-700 text-white focus:bg-slate-700 text-center text-xs px-1"
                                                oninput="updateUI()" placeholder="Gaji Saya">
                                            <input type="number" id="b-target-inc" value="15000000"
                                                class="pro-input bg-slate-800 border-slate-700 text-white focus:bg-slate-700 text-center text-xs px-1"
                                                oninput="updateUI()" placeholder="Gaji Target">
                                            <select id="b-rel"
                                                class="pro-input bg-slate-800 border-slate-700 text-white focus:bg-slate-700 text-xs px-1"
                                                onchange="updateUI()">
                                                <option value="match">Agama Sama</option>
                                                <option value="mismatch" selected>Agama Beda</option>
                                            </select>
                                            <select id="b-gap-edu"
                                                class="pro-input bg-slate-800 border-slate-700 text-white focus:bg-slate-700 text-xs px-1"
                                                onchange="updateUI()">
                                                <option value="0" selected>Edu Setara</option>
                                                <option value="1">Beda 1 Lvl</option>
                                                <option value="2">Beda 2 Lvl</option>
                                            </select>
                                        </div>

                                        <div class="bg-black/30 rounded-xl p-2 mb-2">
                                            <p
                                                class="text-[9px] text-slate-400 font-bold mb-1 text-center border-b border-white/10 pb-1">
                                                RINCIAN HITUNGAN</p>
                                            <div id="receipt-b" class="space-y-1">
                                            </div>
                                        </div>

                                        <div class="text-center pt-2 border-t border-white/10">
                                            <p class="text-2xl font-black text-white" id="score-b">0.00</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-slate-800/50 rounded-xl p-3 text-center border border-white/5">
                                    <p class="text-[10px] text-slate-400 uppercase font-bold mb-1">Analisis Pemenang
                                    </p>
                                    <p class="text-xs font-bold text-white" id="sim-insight">...</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

        </main>
    </div>

    <script>
        function updateUI() {
            // 1. UPDATE SLIDER PERCENT
            let total = 0;
            ['religion', 'domisili', 'income', 'education'].forEach(k => {
                let v = parseInt(document.getElementById(`slider-${k}`).value);
                document.getElementById(`val-${k}`).innerText = v;
                total += v;
            });
            const badge = document.getElementById('totalPercent');
            const badgeBg = document.getElementById('totalPercentBadge');
            badge.innerText = total + "%";
            badgeBg.className = (total !== 100) ?
                "bg-red-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-lg animate-pulse" :
                "bg-slate-900 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-lg";

            // 2. HITUNG SKENARIO
            const resA = calculateScenario('a');
            const resB = calculateScenario('b');

            // 3. ANIMASI ANGKA FINAL
            animateValue("score-a", parseFloat(document.getElementById("score-a").innerText), resA.final, 300);
            animateValue("score-b", parseFloat(document.getElementById("score-b").innerText), resB.final, 300);

            // 4. GENERATE RECEIPT (STRUK DETAIL)
            renderReceipt('receipt-a', resA);
            renderReceipt('receipt-b', resB);

            // 5. UPDATE INSIGHT
            const diff = Math.abs(resA.final - resB.final);
            const insight = document.getElementById('sim-insight');
            if (diff < 0.05) insight.innerHTML = "⚖️ Hasil Seimbang";
            else if (resA.final > resB.final) insight.innerHTML =
                "🏆 <span class='text-blue-400'>Skenario A</span> Unggul (" + diff.toFixed(2) + " poin)";
            else insight.innerHTML = "🏆 <span class='text-yellow-400'>Skenario B</span> Unggul (" + diff.toFixed(2) +
                " poin)";
        }

        function calculateScenario(prefix) {
            // AMBIL CONFIG
            const wRel = parseInt(document.getElementById('slider-religion').value) / 100;
            const wInc = parseInt(document.getElementById('slider-income').value) / 100;
            const wEdu = parseInt(document.getElementById('slider-education').value) / 100;
            const wLoc = parseInt(document.getElementById('slider-domisili').value) / 100;

            const ptRelMatch = parseFloat(document.getElementById('inp-rel-match').value) || 0;
            const ptRelMiss = parseFloat(document.getElementById('inp-rel-miss').value) || 0;
            const ptLocMatch = parseFloat(document.getElementById('inp-loc-match').value) || 0;
            const ptLocMiss = parseFloat(document.getElementById('inp-loc-miss').value) || 0;
            const ptBonusInc = parseFloat(document.getElementById('inp-bonus-inc').value) || 0;
            const ptBonusEdu = parseFloat(document.getElementById('inp-bonus-edu').value) || 0;

            // AMBIL DUMMY DATA
            const uInc = parseInt(document.getElementById(`${prefix}-user-inc`).value) || 0;
            const tInc = parseInt(document.getElementById(`${prefix}-target-inc`).value) || 0;
            const simRel = document.getElementById(`${prefix}-rel`).value;
            const simGapEdu = document.getElementById(`${prefix}-gap-edu`).value;

            // LOGIKA PENDAPATAN
            const diffInc = Math.abs(uInc - tInc);
            let ptInc = 1.0;
            const rangeInputs = document.querySelectorAll('input[name="income_range_limits[]"]');
            const weightInputs = document.querySelectorAll('input[name="income_range_weights[]"]');
            let ranges = [];
            for (let i = 0; i < rangeInputs.length; i++) ranges.push({
                lim: parseInt(rangeInputs[i].value),
                w: parseFloat(weightInputs[i].value)
            });
            ranges.sort((a, b) => a.lim - b.lim);
            for (let r of ranges) {
                if (diffInc <= r.lim) {
                    ptInc = r.w;
                    break;
                }
            }

            // LOGIKA POIN LAIN
            const ptRel = (simRel === 'match') ? ptRelMatch : ptRelMiss;
            const ptLoc = ptLocMatch; // Asumsi simulasi kota sama
            const ptEdu = parseFloat(document.getElementById(`gap-w-${simGapEdu}`)?.value) || 1.0;

            // HITUNG PER BARIS
            const scoreRel = ptRel * wRel;
            const scoreLoc = ptLoc * wLoc;
            const scoreInc = ptInc * wInc;
            const scoreEdu = ptEdu * wEdu;

            const base = scoreRel + scoreLoc + scoreInc + scoreEdu;

            // BONUS
            let bonus = 0;
            let bonusList = [];
            if (uInc >= tInc) {
                bonus += ptBonusInc;
                bonusList.push({
                    lbl: "Bonus Kaya",
                    val: ptBonusInc
                });
            }
            // Skip bonus edu display for simplicity unless needed

            return {
                final: base + bonus,
                details: [{
                        lbl: "Agama",
                        w: wRel,
                        pt: ptRel,
                        res: scoreRel
                    },
                    {
                        lbl: "Gaji",
                        w: wInc,
                        pt: ptInc,
                        res: scoreInc
                    },
                    {
                        lbl: "Edu",
                        w: wEdu,
                        pt: ptEdu,
                        res: scoreEdu
                    },
                    {
                        lbl: "Kota",
                        w: wLoc,
                        pt: ptLoc,
                        res: scoreLoc
                    },
                ],
                bonus: bonusList
            };
        }

        function renderReceipt(id, res) {
            const container = document.getElementById(id);
            let html = "";

            // Render Baris Utama
            res.details.forEach(d => {
                const color = d.pt >= 4 ? 'text-green-400' : (d.pt >= 3 ? 'text-yellow-400' : 'text-red-400');
                html += `
                <div class="calc-row">
                    <span class="calc-label w-8">${d.lbl}</span>
                    <span class="calc-val text-right flex-1">
                        <span class="text-slate-500">${(d.w*100).toFixed(0)}%</span> x <span class="${color}">${d.pt.toFixed(1)}</span>
                    </span>
                    <span class="calc-val w-8 text-right font-bold text-white">${d.res.toFixed(2)}</span>
                </div>`;
            });

            // Render Bonus (Jika ada)
            res.bonus.forEach(b => {
                html += `
                <div class="calc-row border-t border-white/20 mt-1 pt-1">
                    <span class="calc-label text-blue-300">${b.lbl}</span>
                    <span class="calc-val text-right flex-1 text-blue-300">Reward</span>
                    <span class="calc-val w-8 text-right font-bold text-blue-300">+${b.val.toFixed(2)}</span>
                </div>`;
            });

            container.innerHTML = html;
        }

        function animateValue(id, start, end, duration) {
            const obj = document.getElementById(id);
            if (start === end) return;
            const range = end - start;
            let current = start;
            const increment = end > start ? 0.05 : -0.05;
            const stepTime = Math.abs(Math.floor(duration / (range / increment)));
            const timer = setInterval(function() {
                current += increment;
                if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
                    current = end;
                    clearInterval(timer);
                }
                obj.innerText = parseFloat(current).toFixed(2);
            }, 10);
            obj.innerText = end.toFixed(2);
        }

        document.addEventListener("DOMContentLoaded", updateUI);
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Tersimpan!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#f43f5e',
                timer: 2000,
                showConfirmButton: false,
                background: '#fff',
                customClass: {
                    popup: 'rounded-2xl'
                }
            });
        </script>
    @endif
</body>

</html>
