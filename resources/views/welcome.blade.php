<!DOCTYPE html>
<html lang="id">
<head>
    <title>Sistem Pencarian Jodoh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-text { background: linear-gradient(to right, #ec4899, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body class="bg-white">

    <nav class="flex justify-between items-center py-6 px-10 max-w-7xl mx-auto">
        <div class="flex items-center gap-2">
            <span class="text-3xl">💖</span>
            <span class="font-bold text-xl tracking-tight text-gray-800">Cupid AI</span>
        </div>
        <div class="flex gap-4">
            <a href="/login" class="text-gray-600 font-semibold hover:text-gray-900 px-4 py-2 transition">Masuk</a>
            <a href="/register" class="bg-gray-900 text-white font-bold px-6 py-2 rounded-full hover:bg-gray-800 transition shadow-lg">Daftar Sekarang</a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-20 text-center lg:text-left flex flex-col lg:flex-row items-center gap-12">
        
        <div class="lg:w-1/2 space-y-6">
            <span class="bg-pink-100 text-pink-600 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">Metode Profile Matching</span>
            <h1 class="text-5xl lg:text-7xl font-extrabold text-gray-900 leading-tight">
                Temukan Pasangan <br>
                <span class="gradient-text">Impianmu Disini.</span>
            </h1>
            <p class="text-lg text-gray-500 leading-relaxed max-w-lg mx-auto lg:mx-0">
                Sistem pendukung keputusan cerdas yang membantu Anda menemukan jodoh berdasarkan kriteria agama, domisili, penghasilan, dan pendidikan secara akurat.
            </p>
            <div class="flex gap-4 justify-center lg:justify-start pt-4">
                <a href="/register" class="bg-gradient-to-r from-pink-500 to-purple-600 text-white font-bold px-8 py-4 rounded-full text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition transform">
                    Mulai Mencari 🚀
                </a>
                <a href="#fitur" class="bg-white text-gray-700 border border-gray-200 font-bold px-8 py-4 rounded-full text-lg hover:bg-gray-50 transition">
                    Pelajari Cara Kerja
                </a>
            </div>
        </div>

        <div class="lg:w-1/2 relative">
            <div class="absolute inset-0 bg-gradient-to-tr from-pink-200 to-purple-200 rounded-full filter blur-3xl opacity-50 animate-pulse"></div>
            <div class="relative bg-white/50 backdrop-blur-xl border border-white/50 p-10 rounded-3xl shadow-2xl transform rotate-3 hover:rotate-0 transition duration-500">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex -space-x-4">
                        <div class="w-12 h-12 rounded-full bg-blue-100 border-4 border-white flex items-center justify-center text-xl">👨</div>
                        <div class="w-12 h-12 rounded-full bg-pink-100 border-4 border-white flex items-center justify-center text-xl">👩</div>
                        <div class="w-12 h-12 rounded-full bg-yellow-100 border-4 border-white flex items-center justify-center text-xl">✨</div>
                    </div>
                    <span class="text-green-500 font-bold bg-green-50 px-3 py-1 rounded-lg text-sm">98% Match</span>
                </div>
                <div class="space-y-4">
                    <div class="h-2 bg-gray-200 rounded-full w-3/4"></div>
                    <div class="h-2 bg-gray-200 rounded-full w-full"></div>
                    <div class="h-2 bg-gray-200 rounded-full w-5/6"></div>
                </div>
                <div class="mt-8 flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold">Algoritma</p>
                        <p class="font-bold text-gray-800">SPK Gap Analysis</p>
                    </div>
                    <button class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-bold">Lihat Hasil</button>
                </div>
            </div>
        </div>
    </div>

    <div id="fitur" class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-2xl mb-4">🎯</div>
                <h3 class="text-xl font-bold mb-2">Akurasi Tinggi</h3>
                <p class="text-gray-500">Menggunakan metode Profile Matching untuk menghitung gap antara harapan dan kenyataan.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center text-2xl mb-4">⚖️</div>
                <h3 class="text-xl font-bold mb-2">Kriteria Fleksibel</h3>
                <p class="text-gray-500">Tentukan mana syarat yang wajib (mutlak) dan mana yang hanya sebagai nilai tambah.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-2xl mb-4">🔒</div>
                <h3 class="text-xl font-bold mb-2">Privasi Terjaga</h3>
                <p class="text-gray-500">Data sensitif Anda aman. Foto dan kontak hanya ditampilkan pada kandidat yang relevan.</p>
            </div>
        </div>
    </div>

    <footer class="text-center py-8 text-gray-400 text-sm">
        &copy; {{ date('Y') }} Sistem Pencarian Jodoh - Tugas SPK Kelompok Kami
    </footer>

</body>
</html>