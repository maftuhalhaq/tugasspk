<!DOCTYPE html>
<html lang="id">
<head>
    <title>Masuk - BAMN AMORE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Nunito', sans-serif; }

        /* 1. MESH GRADIENT (Sama dengan Register) */
        .mesh-bg {
            background: linear-gradient(-45deg, #a18cd1, #fbc2eb, #fad0c4, #ff9a9e);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* 2. FLOATING ANIMATION */
        .float-slow { animation: float 6s ease-in-out infinite; }
        .float-fast { animation: float 4s ease-in-out infinite; animation-delay: 1s; }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        /* 3. INPUT FOCUS STYLING */
        .input-group:focus-within label { color: #8b5cf6; } /* Warna Ungu untuk Login */
        .input-group:focus-within i { color: #8b5cf6; }
        .input-group:focus-within input { border-color: #8b5cf6; background-color: #fff; }
    </style>
</head>
<body class="min-h-screen mesh-bg flex items-center justify-center p-4 md:p-6">

    <div class="w-full max-w-5xl bg-white/80 backdrop-blur-2xl rounded-[3rem] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.3)] overflow-hidden flex flex-col md:flex-row relative border-4 border-white/50">

        <div class="hidden md:flex w-1/2 relative overflow-hidden items-center justify-center p-12 bg-gradient-to-br from-white/30 to-white/10">
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-300 rounded-full blur-[100px] opacity-40 animate-pulse"></div>

            <div class="relative w-full max-w-sm z-10">

                <div class="absolute top-0 right-0 w-64 bg-white/60 backdrop-blur-md p-4 rounded-3xl border border-white shadow-lg transform rotate-6 opacity-60 scale-90 float-slow">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-rose-200"></div>
                        <div class="space-y-2 w-full">
                            <div class="h-2 w-20 bg-rose-300/50 rounded-full"></div>
                            <div class="h-2 w-32 bg-gray-200 rounded-full"></div>
                        </div>
                    </div>
                </div>

                <div class="relative bg-white/80 backdrop-blur-xl p-6 rounded-[2rem] shadow-2xl border-2 border-white transform -rotate-2 float-fast">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-purple-400 to-pink-400 flex items-center justify-center text-white text-lg font-bold shadow-md">
                                <i class="fa-solid fa-heart"></i>
                            </div>
                            <div>
                                <h4 class="font-black text-gray-800 text-sm">BAMN AMORE</h4>
                                <p class="text-[10px] text-gray-500 font-bold">Baru saja</p>
                            </div>
                        </div>
                        <span class="bg-red-500 w-3 h-3 rounded-full animate-ping"></span>
                    </div>

                    <div class="bg-purple-50 p-4 rounded-2xl border border-purple-100 mb-4">
                        <p class="text-gray-600 text-sm font-bold leading-relaxed">
                            "Hai! Seseorang dengan kecocokan <span class="text-purple-600">98%</span> baru saja melihat profilmu. Masuk untuk melihat siapa dia! 👀"
                        </p>
                    </div>

                    <div class="h-10 w-full bg-gray-900 rounded-xl flex items-center justify-center text-white text-xs font-bold gap-2 shadow-lg">
                        <span>Login Sekarang</span> <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>

                <div class="absolute -bottom-10 right-10 text-5xl animate-bounce" style="animation-duration: 3s;">🔐</div>
                <div class="absolute top-10 -left-5 text-4xl animate-bounce" style="animation-duration: 4s;">💘</div>

            </div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-14 flex flex-col justify-center relative z-10">

            <div class="mb-10">
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-purple-100 text-purple-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">Selamat Datang</span>
                </div>
                <h2 class="text-4xl font-black text-gray-800 leading-tight">
                    Lanjutkan <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-pink-500">Pencarianmu.</span>
                </h2>
                <p class="text-gray-500 mt-2 font-medium">Masuk kembali untuk melihat update jodohmu.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                        <p class="text-xs font-bold text-red-600">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <form action="/login" method="POST" class="space-y-6">
                @csrf

                <div class="input-group">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 ml-1 transition-colors">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors text-gray-400">
                            <i class="fa-regular fa-envelope text-lg"></i>
                        </div>
                        <input type="email" name="email" class="w-full bg-gray-50 border-2 border-gray-100 text-gray-700 text-sm rounded-2xl focus:ring-0 block p-4 pl-12 font-bold outline-none transition-all placeholder-gray-300" placeholder="email@kamu.com" required>
                    </div>
                </div>

                <div class="input-group">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 ml-1 transition-colors">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors text-gray-400">
                            <i class="fa-solid fa-key"></i>
                        </div>
                        <input type="password" name="password" class="w-full bg-gray-50 border-2 border-gray-100 text-gray-700 text-sm rounded-2xl focus:ring-0 block p-4 pl-12 font-bold outline-none transition-all placeholder-gray-300" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="group w-full bg-gray-900 hover:bg-black text-white font-extrabold py-4 rounded-2xl shadow-xl shadow-purple-200 transition-all transform hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-3 relative overflow-hidden">
                    <span class="relative z-10">Masuk Sekarang</span>
                    <i class="fa-solid fa-right-to-bracket relative z-10 group-hover:translate-x-1 transition-transform"></i>

                    <div class="absolute inset-0 h-full w-full bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-[shimmer_1s_infinite]"></div>
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-10 font-bold">
                Belum punya akun? <a href="/register" class="text-purple-600 hover:text-purple-800 underline decoration-2 underline-offset-2 transition">Daftar dulu disini</a>
            </p>
        </div>

    </div>

</body>
</html>
