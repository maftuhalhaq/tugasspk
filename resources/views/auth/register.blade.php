<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar - BAMN AMORE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Nunito', sans-serif; }

        /* 1. ANIMATED MESH GRADIENT BACKGROUND */
        .mesh-bg {
            background: linear-gradient(-45deg, #ff9a9e, #fad0c4, #fad0c4, #a18cd1, #fbc2eb);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* 2. FLOATING CARDS ANIMATION */
        .float-card { animation: float 6s ease-in-out infinite; }
        .float-card-delay { animation: float 6s ease-in-out infinite; animation-delay: 3s; }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }

        /* 3. CUSTOM INPUT FOCUS EFFECT */
        .input-group:focus-within label { color: #db2777; }
        .input-group:focus-within i { color: #db2777; }
        .input-group:focus-within input { border-color: #db2777; background-color: #fff; }
    </style>
</head>
<body class="min-h-screen mesh-bg flex items-center justify-center p-4 md:p-6">

    <div class="w-full max-w-5xl bg-white/80 backdrop-blur-2xl rounded-[3rem] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.3)] overflow-hidden flex flex-col md:flex-row relative border-4 border-white/50">

        <div class="w-full md:w-1/2 p-8 md:p-14 flex flex-col justify-center relative z-10">

            <div class="mb-8">
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-rose-100 text-rose-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">BAMN AMORE</span>
                </div>
                <h2 class="text-4xl font-black text-gray-800 leading-tight">
                    Mulai Kisah <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-500 to-purple-500">Cintamu Disini.</span>
                </h2>
                <p class="text-gray-500 mt-2 font-medium">Isi data diri untuk menemukan pasangan yang sefrekuensi.</p>
            </div>

            <form action="/register" method="POST" class="space-y-5">
                @csrf

                <div class="input-group">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 ml-1 transition-colors">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors text-gray-400">
                            <i class="fa-regular fa-id-card text-lg"></i>
                        </div>
                        <input type="text" name="name" class="w-full bg-gray-50 border-2 border-gray-100 text-gray-700 text-sm rounded-2xl focus:ring-0 block p-4 pl-12 font-bold outline-none transition-all placeholder-gray-300" placeholder="Siapa namamu?" required>
                    </div>
                </div>

                <div class="input-group">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 ml-1 transition-colors">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors text-gray-400">
                            <i class="fa-regular fa-envelope text-lg"></i>
                        </div>
                        <input type="email" name="email" class="w-full bg-gray-50 border-2 border-gray-100 text-gray-700 text-sm rounded-2xl focus:ring-0 block p-4 pl-12 font-bold outline-none transition-all placeholder-gray-300" placeholder="email@kamu.com" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="input-group">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 ml-1 transition-colors">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors text-gray-400">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <input type="password" name="password" class="w-full bg-gray-50 border-2 border-gray-100 text-gray-700 text-sm rounded-2xl focus:ring-0 block p-4 pl-12 font-bold outline-none transition-all placeholder-gray-300" placeholder="••••••" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 ml-1 transition-colors">Ulangi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors text-gray-400">
                                <i class="fa-solid fa-check-double"></i>
                            </div>
                            <input type="password" name="password_confirmation" class="w-full bg-gray-50 border-2 border-gray-100 text-gray-700 text-sm rounded-2xl focus:ring-0 block p-4 pl-12 font-bold outline-none transition-all placeholder-gray-300" placeholder="••••••" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="group w-full bg-gray-900 hover:bg-black text-white font-extrabold py-4 rounded-2xl shadow-xl shadow-gray-300/50 transition-all transform hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-3 relative overflow-hidden">
                    <span class="relative z-10">Gabung Sekarang</span>
                    <i class="fa-solid fa-arrow-right-long relative z-10 group-hover:translate-x-1 transition-transform"></i>
                    <div class="absolute inset-0 h-full w-full bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-[shimmer_1s_infinite]"></div>
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-8 font-bold">
                Sudah punya akun? <a href="/login" class="text-rose-500 hover:text-rose-700 underline decoration-2 underline-offset-2 transition">Masuk disini</a>
            </p>
        </div>

        <div class="hidden md:flex w-1/2 relative overflow-hidden items-center justify-center p-10">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-gradient-to-bl from-purple-200 to-rose-200 rounded-full blur-3xl opacity-50 animate-pulse"></div>

            <div class="relative w-full max-w-sm">

                <div class="absolute top-0 right-0 w-64 h-80 bg-white rounded-[2rem] shadow-lg transform rotate-6 opacity-60 scale-90 float-card-delay border-2 border-white">
                    <div class="h-32 bg-gray-100 rounded-t-[2rem]"></div>
                </div>

                <div class="relative w-72 bg-white/60 backdrop-blur-xl rounded-[2.5rem] shadow-2xl border-4 border-white p-5 float-card transform -rotate-3">
                    <div class="h-48 rounded-[2rem] bg-gradient-to-br from-rose-400 to-orange-300 relative overflow-hidden flex items-center justify-center mb-4 shadow-inner">
                        <i class="fa-solid fa-user-astronaut text-6xl text-white/80"></i>

                        <div class="absolute bottom-3 right-3 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-black text-rose-500 shadow-sm flex items-center gap-1">
                            <i class="fa-solid fa-heart"></i> 98%
                        </div>
                    </div>

                    <div class="space-y-2 text-center">
                        <div class="h-4 w-3/4 bg-rose-100/50 rounded-full mx-auto"></div>
                        <div class="h-3 w-1/2 bg-gray-100 rounded-full mx-auto"></div>
                    </div>

                    <div class="flex justify-center gap-4 mt-6">
                        <div class="w-12 h-12 rounded-full bg-white shadow-lg flex items-center justify-center text-gray-300 text-xl border border-gray-50">
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-gradient-to-r from-rose-500 to-pink-500 shadow-lg shadow-rose-200 flex items-center justify-center text-white text-2xl transform scale-110">
                            <i class="fa-solid fa-heart"></i>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-white shadow-lg flex items-center justify-center text-blue-400 text-xl border border-gray-50">
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>

                <div class="absolute -top-10 left-0 text-4xl animate-bounce">💌</div>
                <div class="absolute bottom-20 -right-10 text-4xl animate-bounce" style="animation-delay: 1s">✨</div>

            </div>
        </div>

    </div>

</body>
</html>
