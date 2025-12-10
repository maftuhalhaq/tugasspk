<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Dashboard - Cupid AI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <style>body { font-family: 'Nunito', sans-serif; background-color: #f8fafc; }</style>
</head>
<body class="flex h-screen overflow-hidden">

    <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col">
        <div class="h-20 flex items-center px-8 border-b border-gray-100">
            <span class="text-2xl mr-2">💖</span>
            <span class="font-extrabold text-gray-800 text-xl">Admin Panel</span>
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 bg-rose-50 text-rose-600 rounded-xl font-bold transition">
                <i class="fa-solid fa-chart-pie w-6"></i> Dashboard
            </a>
            <a href="/admin/users" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 rounded-xl font-bold transition">
                <i class="fa-solid fa-users w-6"></i> Data Pengguna
                @if($stats['pending_users'] > 0)
                <span class="bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full ml-auto">{{ $stats['pending_users'] }}</span>
                @endif
            </a>
            <a href="/admin/weights" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 rounded-xl font-bold transition">
                <i class="fa-solid fa-scale-balanced w-6"></i> Bobot SPK
            </a>
        </nav>
        <div class="p-4 border-t border-gray-100">
            <form action="/logout" method="POST">
                @csrf
                <button class="w-full flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl font-bold transition">
                    <i class="fa-solid fa-right-from-bracket w-6"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="h-16 bg-white border-b border-gray-200 flex md:hidden items-center px-4 justify-between">
            <span class="font-bold text-lg">Cupid Admin</span>
            <button class="text-gray-500"><i class="fa-solid fa-bars"></i></button>
        </header>

        <main class="flex-1 overflow-y-auto p-6 md:p-10 bg-gray-50">
            
            <h1 class="text-2xl font-black text-gray-800 mb-6">Analitik & Performa</h1>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xl"><i class="fa-solid fa-users"></i></div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase">Total User</p>
                        <p class="text-2xl font-black text-gray-800">{{ $stats['total_users'] }}</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center text-xl"><i class="fa-solid fa-clock"></i></div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase">Menunggu ACC</p>
                        <p class="text-2xl font-black text-gray-800">{{ $stats['pending_users'] }}</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xl"><i class="fa-solid fa-check-circle"></i></div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase">User Aktif</p>
                        <p class="text-2xl font-black text-gray-800">{{ $stats['approved_users'] }}</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center text-xl"><i class="fa-solid fa-heart"></i></div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase">Total Match</p>
                        <p class="text-2xl font-black text-gray-800">{{ $stats['total_matches'] }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-gray-800">Sebaran Domisili User</h3>
                        <button onclick="window.print()" class="text-xs bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-lg font-bold text-gray-600">
                            <i class="fa-solid fa-print mr-1"></i> Cetak Laporan
                        </button>
                    </div>
                    <canvas id="domisiliChart" height="150"></canvas>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4">Pendaftar Terbaru</h3>
                    <div class="space-y-4">
                        @foreach($newUsers as $u)
                        <div class="flex items-center gap-3 pb-3 border-b border-gray-50 last:border-0">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-lg">
                                {{ $u->gender == 'L' ? '👨' : '👩' }}
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-800">{{ $u->name }}</p>
                                <p class="text-xs text-gray-400">{{ $u->domisili }} • {{ $u->created_at->diffForHumans() }}</p>
                            </div>
                            <a href="/admin/users" class="text-xs bg-blue-50 text-blue-600 px-3 py-1 rounded-full font-bold hover:bg-blue-100">Review</a>
                        </div>
                        @endforeach
                        @if($newUsers->isEmpty())
                            <p class="text-sm text-gray-400 text-center py-4">Tidak ada pendaftar baru.</p>
                        @endif
                    </div>
                </div>
            </div>

        </main>
    </div>

    <script>
        const ctx = document.getElementById('domisiliChart').getContext('2d');
        const domisiliData = @json($domisiliData);
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: domisiliData.map(d => d.domisili),
                datasets: [{
                    label: 'Jumlah User',
                    data: domisiliData.map(d => d.total),
                    backgroundColor: '#f43f5e',
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>

</body>
</html>