<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Dashboard - BAMN AMORE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>body { font-family: 'Nunito', sans-serif; background-color: #f8fafc; }</style>
</head>
<body class="flex h-screen overflow-hidden text-gray-800">

    <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col z-20">
        <div class="h-20 flex items-center px-8 border-b border-gray-100">
            <span class="text-2xl mr-2">💘</span>
            <span class="font-black text-xl tracking-tight">BAMN AMORE Admin</span>
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 bg-rose-50 text-rose-600 rounded-xl font-bold transition shadow-sm border border-rose-100">
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
                <button class="w-full flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl font-bold transition text-sm">
                    <i class="fa-solid fa-right-from-bracket w-6"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden bg-slate-50">
        <header class="h-16 bg-white border-b border-gray-200 flex md:hidden items-center px-4 justify-between">
            <span class="font-bold text-lg">BAMN AMORE Admin</span>
            <button class="text-gray-500"><i class="fa-solid fa-bars"></i></button>
        </header>

        <main class="flex-1 overflow-y-auto p-6 md:p-10">

            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-black text-gray-800">Dashboard Overview</h1>
                    <p class="text-gray-500 font-medium">Pantau performa aplikasi BAMN AMORE secara real-time.</p>
                </div>
                <a href="/admin/print" target="_blank" class="bg-white border-2 border-gray-100 text-gray-600 hover:text-rose-500 hover:border-rose-200 px-4 py-2 rounded-xl font-bold text-sm transition flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-print"></i> Laporan PDF
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4 hover:-translate-y-1 transition duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center text-2xl"><i class="fa-solid fa-users"></i></div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total User</p>
                        <p class="text-3xl font-black text-gray-800">{{ $stats['total_users'] }}</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4 hover:-translate-y-1 transition duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-yellow-50 text-yellow-500 flex items-center justify-center text-2xl"><i class="fa-solid fa-clock"></i></div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Menunggu</p>
                        <p class="text-3xl font-black text-gray-800">{{ $stats['pending_users'] }}</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4 hover:-translate-y-1 transition duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-green-50 text-green-500 flex items-center justify-center text-2xl"><i class="fa-solid fa-circle-check"></i></div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">User Aktif</p>
                        <p class="text-3xl font-black text-gray-800">{{ $stats['approved_users'] }}</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4 hover:-translate-y-1 transition duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-2xl"><i class="fa-solid fa-heart"></i></div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total Match</p>
                        <p class="text-3xl font-black text-gray-800">{{ $stats['total_matches'] }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <div class="lg:col-span-2 bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-map-location-dot text-rose-500"></i> Top Domisili User
                    </h3>
                    <div class="h-64">
                        <canvas id="domisiliChart"></canvas>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col">
                    <h3 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-purple-500"></i> Demografi Umur
                    </h3>
                    <p class="text-xs text-gray-400 mb-6">Sebaran kategori usia pengguna.</p>
                    <div class="flex-1 flex items-center justify-center relative">
                        <canvas id="ageChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-user-plus text-blue-500"></i> Pendaftar Terbaru
                </h3>
                <div class="space-y-4">
                    @foreach($newUsers as $u)
                    <div class="flex items-center gap-4 p-4 rounded-2xl hover:bg-slate-50 transition border border-transparent hover:border-slate-100 group">
                        <div class="w-12 h-12 rounded-full bg-slate-100 overflow-hidden">
                            @if($u->profile_photo_path)
                                <img src="{{ asset('storage/' . $u->profile_photo_path) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-200"><i class="fa-solid fa-user"></i></div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-gray-800">{{ $u->name }}</p>
                            <p class="text-xs text-gray-400">{{ $u->domisili }} • {{ $u->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div class="text-right">
                            <span class="block text-[10px] font-bold text-gray-400">{{ $u->created_at->diffForHumans() }}</span>
                            <a href="/admin/users" class="text-xs text-rose-500 font-bold hover:underline opacity-0 group-hover:opacity-100 transition">Review</a>
                        </div>
                    </div>
                    @endforeach
                    @if($newUsers->isEmpty())
                        <div class="text-center py-8 text-gray-400 text-sm">Belum ada pendaftar baru.</div>
                    @endif
                </div>
            </div>

        </main>
    </div>

    <script>
        // 1. Chart Domisili
        const ctxDom = document.getElementById('domisiliChart').getContext('2d');
        const domisiliData = @json($domisiliData);

        new Chart(ctxDom, {
            type: 'bar',
            data: {
                labels: domisiliData.map(d => d.domisili),
                datasets: [{
                    label: 'Jumlah User',
                    data: domisiliData.map(d => d.total),
                    backgroundColor: '#f43f5e', // Rose-500
                    borderRadius: 10,
                    barThickness: 40,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // 2. Chart Umur (Donat Lucu)
        const ctxAge = document.getElementById('ageChart').getContext('2d');
        const ageGroups = @json($ageGroups);

        new Chart(ctxAge, {
            type: 'doughnut',
            data: {
                labels: Object.keys(ageGroups),
                datasets: [{
                    data: Object.values(ageGroups),
                    backgroundColor: [
                        '#f472b6', // Pink 400
                        '#c084fc', // Purple 400
                        '#60a5fa', // Blue 400
                        '#fbbf24'  // Amber 400
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                cutout: '70%', // Bolong tengah agak besar
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8, font: {size: 10} } }
                }
            }
        });
    </script>

</body>
</html>
