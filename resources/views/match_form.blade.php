<!DOCTYPE html>
<html lang="id">
<head>
    <title>Atur Kriteria - Cupid AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-blue-50 min-h-screen">

    <nav class="bg-white border-b border-blue-100 px-8 py-4 flex justify-between items-center sticky top-0 z-10">
        <div class="flex items-center gap-2">
            <span class="text-2xl">🎯</span>
            <span class="font-bold text-blue-900">Target Preferensi</span>
        </div>
        <a href="/cari-jodoh" class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1 font-medium transition">
            &larr; Kembali ke Dashboard
        </a>
    </nav>

    <div class="max-w-3xl mx-auto py-10 px-4">
        
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-blue-900">Apa yang kamu cari?</h1>
            <p class="text-blue-600/70">Sistem akan menghitung kecocokan (SPK) berdasarkan bobot. Centang "Wajib" jika kriteria tersebut tidak bisa ditawar.</p>
        </div>

        <form action="/atur-kriteria" method="POST" class="space-y-4">
            @csrf

            <div class="bg-white p-6 rounded-xl shadow-sm border border-blue-100 flex flex-col md:flex-row gap-6 items-start">
                <div class="flex-1 w-full">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Agama Pasangan</label>
                    <select name="preferred_religion" class="mt-2 w-full p-3 bg-gray-50 border border-gray-200 rounded-lg font-semibold text-gray-700 focus:ring-2 focus:ring-blue-500 outline-none">
                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'] as $rel)
                            <option value="{{ $rel }}" {{ ($preference->preferred_religion ?? '') == $rel ? 'selected' : '' }}>{{ $rel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 w-full md:w-auto min-w-[180px]">
                    <div class="flex items-center justify-between gap-3">
                        <label for="strict_religion" class="text-sm font-bold text-gray-700 cursor-pointer">Wajib Mutlak?</label>
                        <input type="hidden" name="strict_religion" value="0">
                        <input type="checkbox" id="strict_religion" name="strict_religion" value="1" {{ ($preference->strict_religion ?? 1) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 cursor-pointer">
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1 leading-tight">Jika dicentang, kandidat beda agama tidak akan muncul.</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-blue-100 flex flex-col md:flex-row gap-6 items-start">
                <div class="flex-1 w-full">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Domisili (Kota)</label>
                    <input type="text" name="preferred_domisili" value="{{ $preference->preferred_domisili ?? '' }}" class="mt-2 w-full p-3 bg-gray-50 border border-gray-200 rounded-lg font-semibold text-gray-700 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Contoh: Surabaya">
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 w-full md:w-auto min-w-[180px]">
                    <div class="flex items-center justify-between gap-3">
                        <label for="strict_domisili" class="text-sm font-bold text-gray-700 cursor-pointer">Wajib Mutlak?</label>
                        <input type="hidden" name="strict_domisili" value="0">
                        <input type="checkbox" id="strict_domisili" name="strict_domisili" value="1" {{ ($preference->strict_domisili ?? 1) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 cursor-pointer">
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1 leading-tight">Jika dicentang, hanya kandidat dari kota ini yang muncul.</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-blue-100 flex flex-col md:flex-row gap-6 items-start">
                <div class="flex-1 w-full">
                    <label class="text-xs font-bold text-green-600 uppercase tracking-wider">Harapan Gaji (Minimal)</label>
                    <div class="relative mt-2">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 font-bold text-sm">Rp</span>
                        <input type="number" name="preferred_real_income" value="{{ $preference->preferred_income_level ?? '' }}" class="w-full p-3 pl-10 bg-gray-50 border border-gray-200 rounded-lg font-bold text-green-700 focus:ring-2 focus:ring-green-500 outline-none" placeholder="0">
                    </div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 w-full md:w-auto min-w-[180px]">
                    <div class="flex items-center justify-between gap-3">
                        <label for="strict_income" class="text-sm font-bold text-gray-700 cursor-pointer">Wajib Mutlak?</label>
                        <input type="hidden" name="strict_income" value="0">
                        <input type="checkbox" id="strict_income" name="strict_income" value="1" {{ ($preference->strict_income ?? 0) ? 'checked' : '' }} class="w-5 h-5 text-red-500 rounded focus:ring-red-500 cursor-pointer">
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1 leading-tight">Jika dicentang, gaji dibawah nominal ini auto-tolak.</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-blue-100 flex flex-col md:flex-row gap-6 items-start">
                <div class="flex-1 w-full">
                    <label class="text-xs font-bold text-blue-600 uppercase tracking-wider">Pendidikan Minimal</label>
                    <select name="preferred_education_level" class="mt-2 w-full p-3 bg-gray-50 border border-gray-200 rounded-lg font-semibold text-gray-700 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="1" {{ ($preference->preferred_education_level ?? 0) == 1 ? 'selected' : '' }}>SMA / SMK</option>
                        <option value="2" {{ ($preference->preferred_education_level ?? 0) == 2 ? 'selected' : '' }}>Diploma (D3)</option>
                        <option value="3" {{ ($preference->preferred_education_level ?? 0) == 3 ? 'selected' : '' }}>Sarjana (S1)</option>
                        <option value="4" {{ ($preference->preferred_education_level ?? 0) == 4 ? 'selected' : '' }}>Magister (S2)</option>
                        <option value="5" {{ ($preference->preferred_education_level ?? 0) == 5 ? 'selected' : '' }}>Doktor (S3)</option>
                    </select>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 w-full md:w-auto min-w-[180px]">
                    <div class="flex items-center justify-between gap-3">
                        <label for="strict_education" class="text-sm font-bold text-gray-700 cursor-pointer">Wajib Mutlak?</label>
                        <input type="hidden" name="strict_education" value="0">
                        <input type="checkbox" id="strict_education" name="strict_education" value="1" {{ ($preference->strict_education ?? 0) ? 'checked' : '' }} class="w-5 h-5 text-red-500 rounded focus:ring-red-500 cursor-pointer">
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1 leading-tight">Jika dicentang, pendidikan dibawah ini auto-tolak.</p>
                </div>
            </div>

            <div class="pt-6 flex justify-end gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-lg font-bold py-4 px-10 rounded-xl shadow-xl transition transform hover:scale-105 flex items-center gap-2">
                    <span>🚀</span>
                    Simpan & Cari Jodoh
                </button>
            </div>
        </form>
    </div>

</body>
</html>