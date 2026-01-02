<!DOCTYPE html>
<html lang="id">
<head>
    <title>BAMN AMORE - Temukan Jodoh Impian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #fff0f6; overflow-x: hidden; }

        /* Gradient Text yang lebih lembut */
        .gradient-text {
            background: linear-gradient(to right, #fb7185, #d946ef);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Background Animations */
        .blob-anim { animation: blob-bounce 8s infinite ease-in-out; }
        .blob-anim-slow { animation: blob-bounce 12s infinite ease-in-out reverse; }
        @keyframes blob-bounce { 0%, 100% { transform: translate(0, 0) scale(1); } 50% { transform: translate(-20px, -20px) scale(1.05); } }

        /* Glass Effect yang lebih halus */
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        /* Floating Animation */
        .floating { animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }
    </style>
</head>
<body class="min-h-screen relative">

    <div class="fixed top-0 left-0 w-full h-full -z-10 pointer-events-none overflow-hidden">
        <div class="absolute -top-[10%] -left-[10%] w-[600px] h-[600px] bg-pink-200 rounded-full mix-blend-multiply filter blur-[120px] opacity-30 blob-anim"></div>
        <div class="absolute top-[20%] -right-[10%] w-[500px] h-[500px] bg-purple-200 rounded-full mix-blend-multiply filter blur-[120px] opacity-30 blob-anim-slow"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[600px] h-[600px] bg-rose-200 rounded-full mix-blend-multiply filter blur-[120px] opacity-30 blob-anim"></div>
    </div>

    <nav class="flex justify-between items-center py-6 px-6 md:px-12 max-w-7xl mx-auto relative z-20">
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-tr from-rose-400 to-pink-500 p-2.5 rounded-2xl shadow-lg text-white">
                <i class="fa-solid fa-heart text-2xl"></i>
            </div>
            <span class="font-black text-2xl tracking-tight text-gray-800">BAMN AMORE</span>
        </div>
        <div class="flex items-center gap-3 md:gap-6">
            <a href="/login" class="text-gray-600 font-bold hover:text-rose-500 transition text-sm md:text-base hidden sm:block">Masuk</a>
            <a href="/register" class="bg-gray-900 hover:bg-black text-white font-extrabold px-6 py-3 rounded-full shadow-xl transition transform hover:-translate-y-0.5 text-sm md:text-base flex items-center gap-2">
                <span>Daftar Sekarang</span> <i class="fa-solid fa-arrow-right-long"></i>
            </a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 md:px-12 py-12 md:py-24 flex flex-col-reverse lg:flex-row items-center gap-12 lg:gap-20 relative z-10 min-h-[80vh]">

        <div class="lg:w-1/2 space-y-8 text-center lg:text-left">
            <div class="inline-flex items-center gap-2 bg-white border-2 border-pink-100 text-pink-600 px-4 py-2 rounded-full text-xs font-black uppercase tracking-wider shadow-sm">
                <i class="fa-solid fa-wand-magic-sparkles text-lg"></i>
                <span>Sistem Profile Matching Cerdas</span>
            </div>

            <h1 class="text-5xl md:text-7xl font-black text-gray-900 leading-tight tracking-tight">
                Temukan <br class="hidden md:block"> Belahan Jiwamu <br>
                <span class="gradient-text">Secara Ilmiah.</span>
            </h1>

            <p class="text-lg md:text-xl text-gray-500 leading-relaxed max-w-xl mx-auto lg:mx-0 font-medium">
                Lupakan tebak-tebakan. Kami menggunakan algoritma SPK untuk mencocokkan kriteria Anda dengan kandidat yang paling relevan dan akurat.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-4">
                <a href="/register" class="bg-gradient-to-r from-rose-500 to-pink-600 text-white font-extrabold px-8 py-4 rounded-2xl text-lg shadow-xl shadow-rose-200/80 hover:shadow-rose-300 transition transform hover:scale-105 active:scale-95 flex items-center justify-center gap-3">
                    <i class="fa-solid fa-magnifying-glass-heart text-xl"></i>
                    <span>Mulai Mencari Jodoh</span>
                </a>
                <a href="#cara-kerja" class="group bg-white border-2 border-gray-100 text-gray-600 font-bold px-8 py-4 rounded-2xl text-lg hover:border-pink-200 hover:text-pink-500 hover:bg-pink-50/50 transition flex items-center justify-center gap-3">
                   <i class="fa-regular fa-circle-play text-xl group-hover:scale-110 transition"></i>
                   <span>Pelajari Caranya</span>
                </a>
            </div>

            <div class="pt-4 flex items-center justify-center lg:justify-start gap-2 text-sm font-bold text-gray-400">
                <i class="fa-solid fa-shield-heart text-green-500"></i> 100% Privasi Aman & Terjaga
            </div>
        </div>

        <div class="lg:w-1/2 relative w-full max-w-lg lg:max-w-full">
            <div class="absolute inset-0 bg-gradient-to-tr from-rose-200 via-pink-200 to-purple-200 rounded-[4rem] filter blur-[70px] opacity-50 animate-pulse"></div>

            <div class="absolute -top-6 -right-6 bg-white p-4 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] floating z-20">
                <i class="fa-solid fa-ring text-3xl text-yellow-500"></i>
            </div>
            <div class="absolute bottom-12 -left-8 bg-white p-4 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] floating z-20" style="animation-delay: 1.5s;">
                <i class="fa-solid fa-envelope-open-text text-3xl text-rose-500"></i>
            </div>

            <div class="glass-panel p-8 md:p-12 rounded-[3rem] shadow-2xl relative z-10 overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-white/40 to-transparent opacity-50"></div>

                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="flex items-center justify-center gap-4 mb-8 w-full">
                        <div class="w-24 h-24 md:w-32 md:h-32 bg-blue-100 rounded-full border-[6px] border-white shadow-lg flex items-center justify-center text-5xl md:text-6xl relative">
                            👨
                             <div class="absolute -bottom-3 bg-white border border-gray-100 text-gray-600 text-xs font-bold px-3 py-1 rounded-full shadow-sm">Anda</div>
                        </div>

                        <div class="flex-1 h-2 bg-gradient-to-r from-blue-200 via-pink-300 to-rose-200 rounded-full relative overflow-hidden">
                            <div class="absolute top-0 left-0 h-full w-1/2 bg-white/30 animate-pulse"></div>
                             <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-2 rounded-full shadow-sm z-10">
                                <i class="fa-solid fa-heart text-rose-500 text-xl fa-beat"></i>
                            </div>
                        </div>

                        <div class="w-24 h-24 md:w-32 md:h-32 bg-rose-100 rounded-full border-[6px] border-white shadow-lg flex items-center justify-center text-5xl md:text-6xl relative">
                            👩
                            <div class="absolute -bottom-3 bg-white border border-gray-100 text-gray-600 text-xs font-bold px-3 py-1 rounded-full shadow-sm">Kandidat</div>
                        </div>
                    </div>

                    <div class="bg-white/80 backdrop-blur-md p-6 rounded-3xl border border-pink-100 shadow-lg w-full max-w-sm floating" style="animation-delay: 0.5s;">
                        <div class="flex justify-between items-center mb-4">
                             <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Hasil Analisa</span>
                             <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wide flex items-center gap-1">
                                <i class="fa-solid fa-circle-check"></i> Sangat Cocok
                            </span>
                        </div>
                        <div class="flex items-end justify-center gap-2">
                            <span class="text-6xl font-black gradient-text leading-none">98</span>
                            <span class="text-2xl font-bold text-pink-500 mb-2">%</span>
                        </div>
                        <p class="text-center text-gray-500 text-sm font-bold mt-2">Match Rate</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <section id="cara-kerja" class="py-20 relative z-10">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="text-center mb-16">
                <span class="text-rose-500 font-black uppercase tracking-widest text-sm mb-2 block">Keunggulan Kami</span>
                <h2 class="text-3xl md:text-5xl font-black text-gray-900">Kenapa Harus BAMN AMORE? 🤔</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-[0_10px_40px_-10px_rgba(0,0,0,0.05)] border-2 border-transparent hover:border-blue-200 hover:shadow-xl transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full -z-0 opacity-50 group-hover:scale-110 transition"></div>
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center text-3xl mb-6 text-blue-500 shadow-sm relative z-10 group-hover:rotate-12 transition">
                        <i class="fa-solid fa-bullseye"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-800 mb-3 relative z-10">Akurasi Tinggi</h3>
                    <p class="text-gray-500 font-medium leading-relaxed relative z-10">Kami menghitung *gap* antara kriteria Anda dan kandidat menggunakan metode matematis yang teruji, bukan sekadar asumsi.</p>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] shadow-[0_10px_40px_-10px_rgba(0,0,0,0.05)] border-2 border-transparent hover:border-pink-200 hover:shadow-xl transition-all duration-300 group relative overflow-hidden">
                     <div class="absolute top-0 right-0 w-32 h-32 bg-pink-50 rounded-bl-full -z-0 opacity-50 group-hover:scale-110 transition"></div>
                    <div class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center text-3xl mb-6 text-pink-500 shadow-sm relative z-10 group-hover:rotate-12 transition">
                        <i class="fa-solid fa-sliders"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-800 mb-3 relative z-10">Kontrol Penuh</h3>
                    <p class="text-gray-500 font-medium leading-relaxed relative z-10">Anda yang menentukan. Atur mana syarat yang <span class="text-rose-500 font-bold">Wajib</span> dan mana yang hanya sebagai nilai tambah.</p>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] shadow-[0_10px_40px_-10px_rgba(0,0,0,0.05)] border-2 border-transparent hover:border-purple-200 hover:shadow-xl transition-all duration-300 group relative overflow-hidden">
                     <div class="absolute top-0 right-0 w-32 h-32 bg-purple-50 rounded-bl-full -z-0 opacity-50 group-hover:scale-110 transition"></div>
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center text-3xl mb-6 text-purple-500 shadow-sm relative z-10 group-hover:rotate-12 transition">
                        <i class="fa-solid fa-user-lock"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-800 mb-3 relative z-10">Data Aman</h3>
                    <p class="text-gray-500 font-medium leading-relaxed relative z-10">Privasi adalah prioritas. Profil lengkap Anda hanya terbuka bagi mereka yang memiliki tingkat kecocokan tinggi.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 relative z-10">
        <div class="max-w-5xl mx-auto px-6 md:px-12">
            <div class="glass-panel p-10 md:p-16 rounded-[3rem] text-center relative overflow-hidden shadow-2xl">
                <div class="absolute inset-0 bg-gradient-to-r from-rose-100/50 to-purple-100/50 -z-10"></div>
                <h2 class="text-3xl md:text-5xl font-black text-gray-900 mb-6">Siap Bertemu Jodohmu?</h2>
                <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto font-medium">Jangan biarkan jodohmu menunggu terlalu lama. Daftar sekarang dan biarkan sistem kami bekerja untuk Anda.</p>
                <a href="/register" class="inline-block bg-gray-900 hover:bg-black text-white font-extrabold px-10 py-5 rounded-2xl text-xl shadow-xl transition transform hover:scale-105 active:scale-95">
                    Buat Akun Gratis <i class="fa-solid fa-arrow-right-long ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <footer class="text-center py-10 text-gray-400 text-sm font-bold relative z-10">
        <p>&copy; {{ date('Y') }} BAMN AMORE. Dibuat dengan 💖 untuk Tugas Kelompok SPK.</p>
    </footer>

</body>
</html>
