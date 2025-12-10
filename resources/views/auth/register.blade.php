<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar - Sistem Pencarian Jodoh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
        
        <div class="w-full md:w-1/2 p-10 flex flex-col justify-center order-2 md:order-1">
            <h3 class="text-2xl font-bold text-gray-800 mb-1">Buat Akun Baru</h3>
            <p class="text-sm text-gray-500 mb-6">Langkah awal menemukan pasangan ideal.</p>

            <form action="/register" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-pink-500 outline-none" placeholder="Contoh: Budi Santoso" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Email Address</label>
                    <input type="email" name="email" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-pink-500 outline-none" placeholder="nama@email.com" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Password</label>
                        <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-pink-500 outline-none" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Ulangi Password</label>
                        <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-pink-500 outline-none" required>
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold py-3 rounded-lg transition transform active:scale-95 mt-4">
                    Daftar Sekarang
                </button>
            </form>

            <p class="text-center text-xs text-gray-400 mt-6">
                Sudah punya akun? <a href="/login" class="text-rose-600 font-bold hover:underline">Masuk disini</a>
            </p>
        </div>

        <div class="hidden md:flex w-1/2 bg-gradient-to-br from-rose-500 to-pink-600 p-10 flex-col justify-between text-white relative overflow-hidden order-1 md:order-2">
            <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="relative z-10 text-right">
                <span class="text-3xl">🚀</span>
                <h2 class="text-3xl font-bold mt-4">Mulai Perjalanan<br>Cintamu.</h2>
                <p class="mt-4 text-pink-100 text-sm opacity-90">"Bergabunglah dengan ribuan pengguna lain yang mencari pasangan serius menggunakan metode ilmiah."</p>
            </div>
            <div class="text-xs opacity-50 relative z-10 text-right">
                &copy; Cupid AI System
            </div>
        </div>

    </div>

</body>
</html>