<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login - Sistem Pencarian Jodoh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row h-[500px]">
        
        <div class="hidden md:flex w-1/2 bg-gradient-to-br from-purple-600 to-blue-600 p-10 flex-col justify-between text-white relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="relative z-10">
                <span class="text-3xl">💘</span>
                <h2 class="text-3xl font-bold mt-4">Temukan yang<br>Sefrekuensi.</h2>
                <p class="mt-4 text-purple-100 text-sm opacity-90">"Jodoh bukan tentang siapa yang datang paling cepat, tapi siapa yang paling tepat menurut perhitungan SPK."</p>
            </div>
            <div class="text-xs opacity-50 relative z-10">
                &copy; Cupid AI System
            </div>
        </div>

        <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-1">Selamat Datang Kembali!</h3>
            <p class="text-sm text-gray-500 mb-8">Masuk untuk melihat hasil pencarian jodohmu.</p>

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 text-xs p-3 rounded mb-4 border border-red-100">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="/login" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Email Address</label>
                    <input type="email" name="email" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition" placeholder="nama@email.com" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Password</label>
                    <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition" placeholder="••••••••" required>
                </div>
                
                <button type="submit" class="w-full bg-gray-900 hover:bg-black text-white font-bold py-3 rounded-lg transition transform active:scale-95">
                    Masuk Sekarang
                </button>
            </form>

            <p class="text-center text-xs text-gray-400 mt-8">
                Belum punya akun? <a href="/register" class="text-purple-600 font-bold hover:underline">Daftar disini</a>
            </p>
        </div>

    </div>

</body>
</html>