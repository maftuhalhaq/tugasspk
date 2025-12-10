<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Dashboard - SPK Jodoh</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-800 text-white p-10">
    <h1 class="text-3xl font-bold mb-6">👨‍💻 Dashboard Admin</h1>

    <form action="/logout" method="POST">
        @csrf
        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            Logout Admin
        </button>
    </form>
    
    <div class="mb-8 flex gap-4">
        <a href="/admin/dashboard" class="text-blue-400 hover:underline">Laporan Statistik</a>
        <a href="/admin/bobot" class="text-blue-400 hover:underline">Atur Pembobotan SPK</a>
        <a href="/admin/users" class="text-blue-400 hover:underline">Validasi User</a>
    </div>

    <div class="grid grid-cols-3 gap-6">
        <div class="bg-gray-700 p-6 rounded text-center">
            <h3 class="text-xl">Total Pengguna</h3>
            <p class="text-4xl font-bold text-yellow-400">{{ $totalUsers }}</p>
        </div>
        <div class="bg-gray-700 p-6 rounded text-center">
            <h3 class="text-xl">User Pria</h3>
            <p class="text-4xl font-bold text-blue-400">{{ $totalPria }}</p>
        </div>
        <div class="bg-gray-700 p-6 rounded text-center">
            <h3 class="text-xl">User Wanita</h3>
            <p class="text-4xl font-bold text-pink-400">{{ $totalWanita }}</p>
        </div>
    </div>
</body>
</html>