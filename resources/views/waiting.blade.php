<!DOCTYPE html>
<html lang="id">
<head>
    <title>Menunggu Verifikasi - Cupid AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>body { font-family: 'Nunito', sans-serif; background-color: #fff0f6; }</style>
</head>
<body class="h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <div class="absolute top-0 left-0 w-full h-full -z-10">
        <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-[80px] opacity-40 animate-pulse"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-[80px] opacity-40 animate-pulse"></div>
    </div>

    <div class="max-w-lg w-full bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-2xl p-10 text-center relative border-4 border-white">
        
        <div class="mb-6 inline-block relative">
            <div class="w-32 h-32 bg-pink-50 rounded-full flex items-center justify-center border-4 border-pink-100 shadow-inner">
                <i class="fa-solid fa-hourglass-half text-5xl text-rose-400 fa-spin-pulse" style="--fa-animation-duration: 3s;"></i>
            </div>
            <div class="absolute bottom-0 right-0 bg-white p-2 rounded-full shadow-md">
                <i class="fa-solid fa-user-check text-green-500 text-xl"></i>
            </div>
        </div>

        <h1 class="text-3xl font-black text-gray-800 mb-2">Profil Sedang Ditinjau 🧐</h1>
        
        <p class="text-gray-500 font-medium mb-6 leading-relaxed">
            Terima kasih sudah melengkapi data! <br>
            Agar komunitas <strong>Cupid AI</strong> tetap aman dan berkualitas, admin kami sedang memverifikasi foto dan data kamu.
        </p>

        <div class="bg-yellow-50 border border-yellow-100 rounded-2xl p-4 text-sm text-yellow-700 font-bold mb-8 flex items-center gap-3 text-left">
            <i class="fa-solid fa-circle-info text-xl"></i>
            <span>Proses ini biasanya memakan waktu 1x24 jam. Cek lagi nanti ya!</span>
        </div>
        
        <div class="flex flex-col gap-3">
            <a href="/profil" class="text-rose-500 font-bold hover:underline text-sm mb-2">
                Masih ada yang salah? Edit Profil lagi
            </a>

            <form action="/logout" method="POST">
                @csrf
                <button class="w-full bg-gray-900 hover:bg-black text-white font-bold py-3.5 rounded-xl transition shadow-lg flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar Dulu
                </button>
            </form>
        </div>
    </div>

</body>
</html>