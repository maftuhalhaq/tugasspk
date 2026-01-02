<!DOCTYPE html>
<html lang="id">
<head>
    <title>Atur Kriteria - BAMN AMORE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #fff0f6; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #f9a8d4; border-radius: 10px; border: 2px solid #fff0f6; }

        /* Glass Effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 0.8);
        }

        /* Custom Toggle Switch */
        .toggle-checkbox:checked { right: 0; border-color: #f43f5e; }
        .toggle-checkbox:checked + .toggle-label { background-color: #f43f5e; }

        .card-transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="min-h-screen flex flex-col text-gray-700 relative">

    <header class="bg-white/90 backdrop-blur-md shadow-sm z-30 h-16 md:h-20 flex justify-between items-center px-4 md:px-8 border-b-2 border-pink-100 sticky top-0">
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-tr from-rose-400 to-pink-400 p-2 md:p-2.5 rounded-xl md:rounded-2xl shadow-lg text-white blob-anim">
                <i class="fa-solid fa-heart text-lg md:text-2xl"></i>
            </div>
            <div>
                <h1 class="text-lg md:text-2xl font-extrabold text-gray-800 tracking-tight leading-none">BAMN AMORE</h1>
                <p class="text-[9px] md:text-[10px] text-pink-500 font-bold uppercase tracking-widest hidden sm:block">Atur Kriteria</p>
            </div>
        </div>

        <a href="/cari-jodoh" class="group bg-white border-2 border-pink-100 text-gray-400 hover:text-rose-500 hover:border-rose-200 hover:bg-rose-50 transition-all font-bold text-xs md:text-sm px-4 py-2 rounded-full flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-arrow-left text-sm group-hover:-translate-x-1 transition-transform duration-300"></i>
            <span>Kembali</span>
        </a>
    </header>

    <main class="flex-1 container mx-auto px-4 py-8 md:py-12 max-w-4xl relative">

        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute top-40 left-10 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-[80px] opacity-30 animate-blob"></div>
            <div class="absolute bottom-20 right-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-[80px] opacity-30 animate-blob animation-delay-2000"></div>
        </div>

        <div class="glass-card rounded-[2rem] p-6 md:p-10 shadow-xl shadow-pink-100/50">

            <div class="mb-8 border-b-2 border-dashed border-pink-100 pb-6 text-center md:text-left">
                <h1 class="text-2xl md:text-3xl font-black text-gray-800 mb-2 flex items-center justify-center md:justify-start gap-2">
                    <i class="fa-solid fa-sliders text-rose-500"></i> Preferensi Jodoh
                </h1>
                <p class="text-sm text-gray-500 font-medium">
                    Sistem akan mencarikan yang paling pas. Aktifkan tombol <span class="text-rose-500 font-bold bg-rose-50 px-2 py-0.5 rounded-md border border-rose-100">Wajib</span> jika kriteria tersebut harus terpenuhi.
                </p>
            </div>

            <form action="/atur-kriteria" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div id="card_religion" class="card-transition bg-white border-2 border-gray-100 p-5 rounded-3xl relative overflow-hidden group hover:shadow-md">
                        <div class="flex justify-between items-center mb-3">
                            <label class="text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                <i class="fa-solid fa-hands-praying text-purple-400 text-lg"></i> Agama
                            </label>
                            <div class="flex items-center gap-2">
                                <span id="txt_religion" class="text-[9px] font-bold text-gray-400 uppercase transition-colors">Opsional</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" name="strict_religion" value="0">
                                    <input type="checkbox" id="chk_religion" name="strict_religion" value="1" class="sr-only peer" {{ ($preference->strict_religion ?? 1) ? 'checked' : '' }} onchange="updateCardStyle('religion')">
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-rose-500"></div>
                                </label>
                            </div>
                        </div>
                        <select name="preferred_religion" class="w-full bg-gray-50 border-0 text-gray-700 text-sm rounded-xl focus:ring-2 focus:ring-purple-200 focus:bg-white block p-3 font-bold transition cursor-pointer hover:bg-gray-100">
                            @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'] as $agama)
                                <option value="{{ $agama }}" {{ ($preference->preferred_religion ?? '') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="card_domisili" class="card-transition bg-white border-2 border-gray-100 p-5 rounded-3xl relative overflow-hidden group hover:shadow-md">
                        <div class="flex justify-between items-center mb-3">
                            <label class="text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                <i class="fa-solid fa-map-location-dot text-pink-400 text-lg"></i> Kota Asal
                            </label>
                            <div class="flex items-center gap-2">
                                <span id="txt_domisili" class="text-[9px] font-bold text-gray-400 uppercase transition-colors">Opsional</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" name="strict_domisili" value="0">
                                    <input type="checkbox" id="chk_domisili" name="strict_domisili" value="1" class="sr-only peer" {{ ($preference->strict_domisili ?? 1) ? 'checked' : '' }} onchange="updateCardStyle('domisili')">
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-rose-500"></div>
                                </label>
                            </div>
                        </div>
                        <input type="text" name="preferred_domisili" value="{{ $preference->preferred_domisili ?? 'Malang' }}" class="w-full bg-gray-50 border-0 text-gray-700 text-sm rounded-xl focus:ring-2 focus:ring-pink-200 focus:bg-white block p-3 font-bold transition placeholder-gray-300" placeholder="Contoh: Malang">
                    </div>

                    <div id="card_age" class="card-transition bg-white border-2 border-gray-100 p-5 rounded-3xl relative overflow-hidden group hover:shadow-md md:col-span-2">
                        <div class="flex justify-between items-center mb-3">
                            <label class="text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                <i class="fa-solid fa-cake-candles text-orange-400 text-lg"></i> Rentang Usia
                            </label>
                            <div class="flex items-center gap-2">
                                <span id="txt_age" class="text-[9px] font-bold text-gray-400 uppercase transition-colors">Opsional</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="chk_age" class="sr-only peer" checked onchange="updateCardStyle('age')">
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-rose-500"></div>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <label class="text-[10px] font-bold text-gray-400 ml-1">Minimal</label>
                                <input type="number" name="min_age" value="{{ $preference->min_age ?? 18 }}" class="w-full bg-gray-50 border-0 text-gray-700 text-sm rounded-xl focus:ring-2 focus:ring-orange-200 focus:bg-white block p-3 font-bold transition">
                            </div>
                            <span class="text-gray-300 font-bold mt-4">-</span>
                            <div class="flex-1">
                                <label class="text-[10px] font-bold text-gray-400 ml-1">Maksimal</label>
                                <input type="number" name="max_age" value="{{ $preference->max_age ?? 30 }}" class="w-full bg-gray-50 border-0 text-gray-700 text-sm rounded-xl focus:ring-2 focus:ring-orange-200 focus:bg-white block p-3 font-bold transition">
                            </div>
                        </div>
                    </div>

                    <div id="card_education" class="card-transition bg-white border-2 border-gray-100 p-5 rounded-3xl relative overflow-hidden group hover:shadow-md">
                        <div class="flex justify-between items-center mb-3">
                            <label class="text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                <i class="fa-solid fa-graduation-cap text-blue-400 text-lg"></i> Pendidikan
                            </label>
                            <div class="flex items-center gap-2">
                                <span id="txt_education" class="text-[9px] font-bold text-gray-400 uppercase transition-colors">Opsional</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" name="strict_education" value="0">
                                    <input type="checkbox" id="chk_education" name="strict_education" value="1" class="sr-only peer" {{ ($preference->strict_education ?? 0) ? 'checked' : '' }} onchange="updateCardStyle('education')">
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-rose-500"></div>
                                </label>
                            </div>
                        </div>
                        <select name="preferred_education_level" class="w-full bg-gray-50 border-0 text-gray-700 text-sm rounded-xl focus:ring-2 focus:ring-blue-200 focus:bg-white block p-3 font-bold transition cursor-pointer hover:bg-gray-100">
                            <option value="1" {{ ($preference->preferred_education_level ?? 0) == 1 ? 'selected' : '' }}>SMA / SMK</option>
                            <option value="2" {{ ($preference->preferred_education_level ?? 0) == 2 ? 'selected' : '' }}>Diploma (D3)</option>
                            <option value="3" {{ ($preference->preferred_education_level ?? 0) == 3 ? 'selected' : '' }}>Sarjana (S1)</option>
                            <option value="4" {{ ($preference->preferred_education_level ?? 0) == 4 ? 'selected' : '' }}>Magister (S2)</option>
                            <option value="5" {{ ($preference->preferred_education_level ?? 0) == 5 ? 'selected' : '' }}>Doktor (S3)</option>
                        </select>
                    </div>

                    <div id="card_income" class="card-transition bg-white border-2 border-gray-100 p-5 rounded-3xl relative overflow-hidden group hover:shadow-md">
                        <div class="flex justify-between items-center mb-3">
                            <label class="text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                <i class="fa-solid fa-sack-dollar text-green-400 text-lg"></i> Min. Gaji
                            </label>
                            <div class="flex items-center gap-2">
                                <span id="txt_income" class="text-[9px] font-bold text-gray-400 uppercase transition-colors">Opsional</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" name="strict_income" value="0">
                                    <input type="checkbox" id="chk_income" name="strict_income" value="1" class="sr-only peer" {{ ($preference->strict_income ?? 0) ? 'checked' : '' }} onchange="updateCardStyle('income')">
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-rose-500"></div>
                                </label>
                            </div>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="text-green-600 font-bold">Rp</span>
                            </div>
                            <input type="number" name="preferred_real_income" value="{{ $preference->preferred_income_level ?? '' }}" class="w-full bg-gray-50 border-0 text-gray-700 text-sm rounded-xl focus:ring-2 focus:ring-green-200 focus:bg-white block p-3 pl-10 font-bold transition placeholder-gray-300" placeholder="0">
                        </div>
                    </div>

                </div>

                <div class="pt-6 border-t border-gray-100 flex flex-col-reverse md:flex-row items-center justify-end gap-3 md:gap-4">
                    <a href="/cari-jodoh" class="w-full md:w-auto text-center px-6 py-3.5 rounded-2xl text-sm font-bold text-gray-500 hover:bg-gray-100 transition border border-transparent hover:border-gray-200">
                        Batal
                    </a>
                    <button type="submit" class="w-full md:w-auto bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white text-sm md:text-base font-extrabold py-3.5 px-8 rounded-2xl shadow-xl shadow-rose-200 transition transform hover:scale-105 active:scale-95 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-magnifying-glass-heart"></i>
                        Simpan & Cari Jodoh
                    </button>
                </div>

            </form>
        </div>
    </main>

    <script>
        function updateCardStyle(key) {
            const checkbox = document.getElementById('chk_' + key);
            const card = document.getElementById('card_' + key);
            const text = document.getElementById('txt_' + key);

            if (checkbox.checked) {
                // Style STRICT (Merah - Tegas)
                card.classList.remove('border-gray-100', 'bg-white');
                card.classList.add('border-rose-200', 'bg-rose-50/50');

                text.innerText = "SYARAT UTAMA";
                text.classList.remove('text-gray-400');
                text.classList.add('text-rose-500');
            } else {
                // Style OPSIONAL (Netral - Santai)
                card.classList.add('border-gray-100', 'bg-white');
                card.classList.remove('border-rose-200', 'bg-rose-50/50');

                text.innerText = "PREFERENSI SAJA";
                text.classList.remove('text-rose-500');
                text.classList.add('text-gray-400');
            }
        }

        // Animasi Card
        anime({
            targets: '.glass-card',
            translateY: [20, 0],
            opacity: [0, 1],
            easing: 'spring(1, 80, 10, 0)',
            duration: 800
        });

        window.addEventListener('DOMContentLoaded', () => {
            ['religion', 'domisili', 'education', 'income', 'age'].forEach(key => updateCardStyle(key));
        });
    </script>

</body>
</html>
