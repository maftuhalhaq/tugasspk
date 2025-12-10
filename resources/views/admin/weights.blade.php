<!DOCTYPE html>
<html lang="id">
<head>
    <title>Atur Bobot SPK - Cupid Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #f8fafc; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800">

    <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col z-20">
        <div class="h-20 flex items-center px-8 border-b border-slate-100">
            <span class="text-2xl mr-2">💘</span>
            <span class="font-black text-xl tracking-tight text-slate-800">Cupid Admin</span>
        </div>
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 mt-2">Menu Utama</p>
            <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl font-bold transition group">
                <i class="fa-solid fa-chart-pie w-5 text-center group-hover:text-rose-500 transition-colors"></i> Dashboard
            </a>
            <a href="/admin/users" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl font-bold transition group">
                <i class="fa-solid fa-users w-5 text-center group-hover:text-rose-500 transition-colors"></i> Validasi User
            </a>
            <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 mt-6">Konfigurasi</p>
            <a href="/admin/weights" class="flex items-center gap-3 px-4 py-3 bg-rose-50 text-rose-600 rounded-xl font-bold transition shadow-sm border border-rose-100">
                <i class="fa-solid fa-sliders w-5 text-center"></i> Bobot SPK
            </a>
            <a href="/admin/print" target="_blank" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl font-bold transition group">
                <i class="fa-solid fa-print w-5 text-center group-hover:text-rose-500 transition-colors"></i> Cetak Laporan
            </a>
        </nav>
        <div class="p-4 border-t border-slate-100">
            <form action="/logout" method="POST">
                @csrf
                <button class="w-full flex items-center justify-center gap-2 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl font-bold transition text-sm">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden bg-slate-50 relative">
        <main class="flex-1 overflow-y-auto p-6 md:p-10 relative z-10">
            
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h1 class="text-3xl font-black text-slate-800">Konfigurasi Bobot (Gap)</h1>
                    <p class="text-slate-500 font-medium mt-1">Atur nilai bobot untuk setiap selisih kriteria (Profile Matching).</p>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden max-w-4xl">
                <div class="p-8 bg-slate-900 text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="font-bold text-lg"><i class="fa-solid fa-calculator mr-2"></i> Tabel Bobot GAP</h3>
                        <p class="text-slate-400 text-xs mt-1">Nilai GAP = Profil User - Profil Target</p>
                    </div>
                    <div class="absolute top-0 right-0 w-32 h-32 bg-rose-500 rounded-full blur-[60px] opacity-20"></div>
                </div>

                <form action="/admin/weights" method="POST" class="p-6">
                    @csrf
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100 text-xs uppercase font-bold text-slate-400">
                                    <th class="py-3 px-4">Selisih (Gap)</th>
                                    <th class="py-3 px-4">Keterangan</th>
                                    <th class="py-3 px-4 w-32">Nilai Bobot</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm font-bold text-slate-600 divide-y divide-slate-50">
                                @foreach($weights as $w)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3 px-4">
                                        <span class="bg-slate-100 px-2 py-1 rounded text-slate-500">{{ $w->gap }}</span>
                                    </td>
                                    <td class="py-3 px-4">{{ $w->description }}</td>
                                    <td class="py-3 px-4">
                                        <input type="number" step="0.1" name="weights[{{ $w->id }}]" value="{{ $w->weight }}" 
                                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-center focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none transition font-bold text-slate-800">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8 flex justify-end border-t border-slate-50 pt-6">
                        <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-rose-200 transition transform hover:-translate-y-1">
                            <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </main>
    </div>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            confirmButtonColor: '#f43f5e'
        });
    </script>
    @endif

</body>
</html>