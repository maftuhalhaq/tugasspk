<!DOCTYPE html>
<html lang="id">
<head>
    <title>Manajemen User - Cupid Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #f8fafc; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        .active-tab { border-bottom: 3px solid #f43f5e; color: #f43f5e; }
        .inactive-tab { border-bottom: 3px solid transparent; color: #94a3b8; }
        .inactive-tab:hover { color: #64748b; }
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
            <a href="/admin/users" class="flex items-center gap-3 px-4 py-3 bg-rose-50 text-rose-600 rounded-xl font-bold transition shadow-sm border border-rose-100">
                <i class="fa-solid fa-users w-5 text-center"></i> Validasi User
            </a>
            <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 mt-6">Konfigurasi</p>
            <a href="/admin/weights" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl font-bold transition group">
                <i class="fa-solid fa-sliders w-5 text-center group-hover:text-rose-500 transition-colors"></i> Bobot SPK
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
        
        <header class="h-16 bg-white/80 backdrop-blur border-b border-slate-200 flex md:hidden items-center px-4 justify-between sticky top-0 z-30">
            <span class="font-bold text-lg flex items-center gap-2"><span class="text-2xl">💘</span> Admin</span>
            </header>

        <main class="flex-1 overflow-y-auto p-6 md:p-10 relative z-10">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-black text-slate-800">Manajemen Pengguna</h1>
                    <p class="text-slate-500 font-medium">Verifikasi pendaftar baru dan kelola pengguna aktif.</p>
                </div>
            </div>

            <div class="flex border-b border-slate-200 mb-6 space-x-6">
                <button onclick="switchTab('pending')" id="tab-pending" class="pb-3 text-sm font-extrabold active-tab transition">
                    ⏳ Menunggu Verifikasi
                    @if($users->where('status', 'pending')->count() > 0)
                        <span class="ml-2 bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full">{{ $users->where('status', 'pending')->count() }}</span>
                    @endif
                </button>
                <button onclick="switchTab('approved')" id="tab-approved" class="pb-3 text-sm font-bold inactive-tab transition">
                    ✅ Pengguna Aktif
                </button>
            </div>

            <div id="content-pending" class="block animate-fade-in">
                @if($users->where('status', 'pending')->isEmpty())
                    <div class="bg-white p-12 rounded-[2rem] border border-slate-100 text-center">
                        <div class="w-20 h-20 bg-green-50 text-green-500 rounded-full flex items-center justify-center text-4xl mx-auto mb-4">
                            <i class="fa-solid fa-mug-hot"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Semua Bersih!</h3>
                        <p class="text-slate-400">Tidak ada pendaftar baru yang perlu diverifikasi.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($users->where('status', 'pending') as $user)
                        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition relative overflow-hidden group">
                            <div class="absolute top-0 left-0 w-full h-1 bg-yellow-400"></div>
                            
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-slate-100 cursor-pointer" onclick="showDetail({{ $user->id }})">
                                        @if($user->profile_photo_path)
                                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=f1f5f9&color=64748b" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm truncate w-32">{{ $user->name }}</h4>
                                        <p class="text-[10px] text-slate-400 uppercase font-bold">{{ $user->domisili }}</p>
                                    </div>
                                </div>
                                <span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-2 py-1 rounded-lg">PENDING</span>
                            </div>

                            <div class="space-y-2 text-xs text-slate-500 mb-6">
                                <div class="flex justify-between border-b border-slate-50 pb-1"><span>Gender:</span> <span class="font-bold">{{ $user->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</span></div>
                                <div class="flex justify-between border-b border-slate-50 pb-1"><span>Agama:</span> <span class="font-bold">{{ $user->religion }}</span></div>
                                <div class="flex justify-between border-b border-slate-50 pb-1"><span>Gaji:</span> <span class="font-bold text-green-600">Rp {{ number_format($user->income_level/1000000, 1) }} Jt</span></div>
                            </div>

                            <div class="flex gap-2">
                                <button onclick="showDetail({{ $user->id }})" class="flex-1 py-2 rounded-xl border border-slate-200 text-slate-500 text-xs font-bold hover:bg-slate-50 transition">Detail</button>
                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full py-2 rounded-xl bg-green-500 text-white text-xs font-bold hover:bg-green-600 transition shadow-sm">
                                        <i class="fa-solid fa-check mr-1"></i> Terima
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div id="content-approved" class="hidden animate-fade-in">
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600">
                            <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-400">
                                <tr>
                                    <th class="px-6 py-4">User</th>
                                    <th class="px-6 py-4">Domisili</th>
                                    <th class="px-6 py-4">Agama</th>
                                    <th class="px-6 py-4">Gaji</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($users->where('status', 'approved') as $user)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4 flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full overflow-hidden bg-slate-200">
                                            @if($user->profile_photo_path)
                                                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" class="w-full h-full object-cover">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <span class="font-bold text-slate-700">{{ $user->name }}</span>
                                    </td>
                                    <td class="px-6 py-4">{{ $user->domisili }}</td>
                                    <td class="px-6 py-4">{{ $user->religion }}</td>
                                    <td class="px-6 py-4 font-mono text-green-600">Rp {{ number_format($user->income_level, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                            @csrf
                                            <button type="submit" class="text-red-400 hover:text-red-600 transition" title="Hapus User">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <div id="userModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg relative z-10 overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalContent">
                
                <button onclick="closeModal()" class="absolute top-4 right-4 bg-black/20 hover:bg-black/40 text-white w-8 h-8 rounded-full flex items-center justify-center z-20">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <div id="modalBody">
                    </div>
            </div>
        </div>
    </div>

    <script>
        // Tab Switcher Logic
        function switchTab(tab) {
            const pendingBtn = document.getElementById('tab-pending');
            const approvedBtn = document.getElementById('tab-approved');
            const pendingContent = document.getElementById('content-pending');
            const approvedContent = document.getElementById('content-approved');

            if(tab === 'pending') {
                pendingBtn.classList.replace('inactive-tab', 'active-tab');
                approvedBtn.classList.replace('active-tab', 'inactive-tab');
                pendingContent.classList.remove('hidden');
                approvedContent.classList.add('hidden');
            } else {
                approvedBtn.classList.replace('inactive-tab', 'active-tab');
                pendingBtn.classList.replace('active-tab', 'inactive-tab');
                approvedContent.classList.remove('hidden');
                pendingContent.classList.add('hidden');
            }
        }

        // Modal Logic
        const usersData = {!! json_encode($users) !!}; // Pass data PHP ke JS

        function showDetail(id) {
            const user = usersData.find(u => u.id === id);
            if(!user) return;

            const modal = document.getElementById('userModal');
            const content = document.getElementById('modalContent');
            const body = document.getElementById('modalBody');
            
            // FIX BUG UMUR 55 TAHUN
            let ageDisplay = 'Belum diisi';
            if (user.date_of_birth) {
                const birthDate = new Date(user.date_of_birth);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                ageDisplay = age + ' Tahun';
            }

            const photoUrl = user.profile_photo_path 
                ? `/storage/${user.profile_photo_path}` 
                : `https://ui-avatars.com/api/?name=${encodeURI(user.name)}`;

            // Isi Modal (Update Tombol Aksi)
            body.innerHTML = `
                <div class="h-48 bg-slate-200 relative">
                    <img src="${photoUrl}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-6 text-white">
                        <h2 class="text-2xl font-black">${user.name}</h2>
                        <p class="text-sm opacity-90">${user.domisili} • ${ageDisplay}</p>
                    </div>
                    <div class="absolute top-4 right-4 bg-white/20 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-white uppercase border border-white/30">
                        Status: ${user.status}
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <p class="text-[10px] uppercase font-bold text-slate-400">Gender</p>
                            <p class="font-bold text-slate-700">${user.gender == 'L' ? 'Laki-laki' : 'Perempuan'}</p>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <p class="text-[10px] uppercase font-bold text-slate-400">Agama</p>
                            <p class="font-bold text-slate-700">${user.religion}</p>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <p class="text-[10px] uppercase font-bold text-slate-400">Pendidikan</p>
                            <p class="font-bold text-slate-700">Level ${user.education_level}</p>
                        </div>
                        <div class="bg-green-50 p-3 rounded-xl border border-green-100">
                            <p class="text-[10px] uppercase font-bold text-green-600">Gaji</p>
                            <p class="font-bold text-green-700">Rp ${new Intl.NumberFormat('id-ID').format(user.income_level)}</p>
                        </div>
                    </div>
                    
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <p class="text-[10px] uppercase font-bold text-slate-400 mb-2">Kontak</p>
                        <div class="flex gap-2">
                            ${user.whatsapp ? `<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold"><i class="fa-brands fa-whatsapp"></i> ${user.whatsapp}</span>` : '<span class="text-xs text-gray-400 italic">Tidak ada WA</span>'}
                            ${user.instagram ? `<span class="bg-pink-100 text-pink-700 px-3 py-1 rounded-full text-xs font-bold"><i class="fa-brands fa-instagram"></i> ${user.instagram}</span>` : ''}
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 pt-2">
                        ${user.status !== 'approved' ? `
                        <form action="/admin/users/${user.id}/approve" method="POST">
                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                            <button class="w-full py-3 rounded-xl bg-green-500 text-white font-bold hover:bg-green-600 transition shadow-lg shadow-green-200">
                                <i class="fa-solid fa-check mr-1"></i> Terima (Approve)
                            </button>
                        </form>
                        ` : ''}

                        <div class="flex gap-2">
                            <form action="/admin/users/${user.id}/reject" method="POST" class="flex-1">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                <button class="w-full py-3 rounded-xl border-2 border-orange-100 bg-orange-50 text-orange-600 font-bold hover:bg-orange-100 transition">
                                    <i class="fa-solid fa-ban mr-1"></i> Tolak (Revisi)
                                </button>
                            </form>

                            <form action="/admin/users/${user.id}/delete" method="POST" class="flex-1" onsubmit="return confirm('Yakin HAPUS PERMANEN user ini?')">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                <button class="w-full py-3 rounded-xl border-2 border-red-100 bg-red-50 text-red-600 font-bold hover:bg-red-100 transition">
                                    <i class="fa-solid fa-trash mr-1"></i> Hapus Akun
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            `;
            
            // ... (Animasi tetap sama) ...
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('userModal');
            const content = document.getElementById('modalContent');
            
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Animasi Card
        anime({
            targets: '#content-pending .group',
            translateY: [20, 0],
            opacity: [0, 1],
            delay: anime.stagger(100),
            easing: 'spring(1, 80, 10, 0)'
        });
    </script>
    
    @if(session('success'))
    <script>
        const Toast = Swal.mixin({
            toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true,
            didOpen: (toast) => { toast.addEventListener('mouseenter', Swal.stopTimer); toast.addEventListener('mouseleave', Swal.resumeTimer); }
        });
        Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
    </script>
    @endif

</body>
</html>