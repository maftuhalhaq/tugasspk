<!DOCTYPE html>
<html lang="id">
<head>
    <title>Manajemen User - BAMN AMORE Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #f8fafc; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        .tab-btn { transition: all 0.3s ease; border-bottom: 3px solid transparent; }
        .tab-active { border-color: #f43f5e; color: #f43f5e; background-color: #fff1f2; }
        .tab-inactive { color: #94a3b8; }
        .tab-inactive:hover { color: #64748b; background-color: #f1f5f9; }

        /* Card Animations */
        .user-card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800">

    <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col z-20">
        <div class="h-20 flex items-center px-8 border-b border-slate-100">
            <span class="text-2xl mr-2">💘</span>
            <span class="font-black text-xl tracking-tight">BAMN AMORE Admin</span>
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

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-black text-slate-800">Manajemen Pengguna</h1>
                    <p class="text-slate-500 font-medium text-sm mt-1">Kelola data pendaftar dan statistik pengguna.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center text-lg"><i class="fa-solid fa-users-line"></i></div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Total User</p>
                        <p class="text-xl font-black text-slate-800">{{ $totalUsers }}</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm col-span-1 md:col-span-2 relative overflow-hidden">
                    <div class="flex justify-between items-end mb-2 relative z-10">
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">Rasio Gender</p>
                            <div class="flex gap-4 text-xs font-bold mt-1">
                                <span class="text-blue-500"><i class="fa-solid fa-mars"></i> {{ $countL }} Pria</span>
                                <span class="text-pink-500"><i class="fa-solid fa-venus"></i> {{ $countP }} Wanita</span>
                            </div>
                        </div>
                        <p class="text-2xl font-black text-slate-800">{{ $percentL }}% <span class="text-sm text-slate-400">vs</span> {{ $percentP }}%</p>
                    </div>
                    <div class="w-full h-2 bg-pink-100 rounded-full overflow-hidden flex">
                        <div style="width: {{ $percentL }}%" class="h-full bg-blue-400"></div>
                        <div style="width: {{ $percentP }}%" class="h-full bg-pink-400"></div>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-green-50 text-green-500 flex items-center justify-center text-lg"><i class="fa-solid fa-money-bill-wave"></i></div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Rata2 Gaji</p>
                        <p class="text-lg font-black text-slate-800 truncate">{{ number_format($avgIncome / 1000000, 1) }} Jt</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-1 rounded-2xl border border-slate-200 inline-flex mb-6 shadow-sm">
                <button onclick="switchTab('pending')" id="tab-pending" class="px-6 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 tab-active tab-btn">
                    <i class="fa-solid fa-hourglass-half"></i> Menunggu
                    @if($users->where('status', 'pending')->count() > 0)
                        <span class="bg-rose-500 text-white text-[10px] px-2 py-0.5 rounded-full ml-1">{{ $users->where('status', 'pending')->count() }}</span>
                    @endif
                </button>
                <button onclick="switchTab('approved')" id="tab-approved" class="px-6 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 tab-inactive tab-btn">
                    <i class="fa-solid fa-circle-check"></i> Sudah Aktif
                </button>
            </div>

            <div id="content-pending" class="block animate-fade-in">
                @if($users->where('status', 'pending')->isEmpty())
                    <div class="bg-white p-16 rounded-[2.5rem] border border-dashed border-slate-300 text-center opacity-75">
                        <div class="w-24 h-24 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center text-5xl mx-auto mb-4"><i class="fa-solid fa-check-double"></i></div>
                        <h3 class="text-xl font-bold text-slate-700">Semua Bersih!</h3>
                        <p class="text-slate-400">Tidak ada pendaftar baru yang perlu diverifikasi.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($users->where('status', 'pending') as $user)
                        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm user-card transition-all duration-300 relative group">
                            <div class="absolute top-4 right-4 bg-yellow-400 text-white text-[10px] font-black px-2 py-0.5 rounded shadow-sm z-10">BARU</div>

                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-16 h-16 rounded-2xl overflow-hidden border-2 border-slate-100 shadow-sm cursor-pointer hover:opacity-80 transition" onclick="showDetail({{ $user->id }})">
                                    @if($user->profile_photo_path)
                                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=f1f5f9&color=64748b" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-black text-slate-800 text-lg truncate">{{ $user->name }}</h4>
                                    <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                                        <span><i class="fa-solid fa-location-dot text-rose-400"></i> {{ $user->domisili }}</span>
                                        <span class="text-slate-300">•</span>
                                        <span>{{ \Carbon\Carbon::parse($user->date_of_birth)->age }} Th</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button onclick="showDetail({{ $user->id }})" class="px-4 py-2.5 rounded-xl border-2 border-slate-100 text-slate-500 text-xs font-extrabold hover:bg-slate-50 transition">Detail</button>
                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full py-2.5 rounded-xl bg-green-500 hover:bg-green-600 text-white text-xs font-extrabold shadow-lg shadow-green-200 transition">
                                        <i class="fa-solid fa-check"></i> Terima
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div id="content-approved" class="hidden animate-fade-in">
                @if($users->where('status', 'approved')->isEmpty())
                    <div class="p-10 text-center text-slate-400 text-sm">Belum ada user aktif.</div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($users->where('status', 'approved') as $user)
                        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm user-card transition-all duration-300 relative group">

                            <div class="absolute top-4 right-4 bg-green-100 text-green-600 text-[10px] font-black px-2 py-0.5 rounded shadow-sm z-10 flex items-center gap-1">
                                <i class="fa-solid fa-circle-check"></i> AKTIF
                            </div>

                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-16 h-16 rounded-2xl overflow-hidden border-2 border-green-100 shadow-sm cursor-pointer hover:opacity-80 transition" onclick="showDetail({{ $user->id }})">
                                    @if($user->profile_photo_path)
                                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=f0fdf4&color=16a34a" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-black text-slate-800 text-lg truncate">{{ $user->name }}</h4>
                                    <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                                        <span><i class="fa-solid fa-location-dot text-green-500"></i> {{ $user->domisili }}</span>
                                        <span class="text-slate-300">•</span>
                                        <span>{{ \Carbon\Carbon::parse($user->date_of_birth)->age }} Th</span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-2 mb-5">
                                <div class="bg-slate-50 p-2 rounded-xl text-center">
                                    <p class="text-[9px] uppercase font-bold text-slate-400">Pendidikan</p>
                                    <p class="text-xs font-bold text-slate-700">Strata {{ $user->education_level }}</p>
                                </div>
                                <div class="bg-slate-50 p-2 rounded-xl text-center">
                                    <p class="text-[9px] uppercase font-bold text-slate-400">Gaji</p>
                                    <p class="text-xs font-bold text-green-600">Rp {{ number_format($user->income_level/1000000, 1) }} Jt</p>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <button onclick="showDetail({{ $user->id }})" class="flex-1 py-2.5 rounded-xl border-2 border-slate-100 text-slate-500 text-xs font-extrabold hover:bg-slate-50 transition">
                                    Detail
                                </button>

                                <form action="{{ route('admin.users.reject', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-2.5 rounded-xl bg-orange-50 text-orange-500 hover:bg-orange-100 transition text-xs font-bold" title="Blokir / Suspend User">
                                        <i class="fa-solid fa-ban"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Hapus permanen {{ $user->name }}?');">
                                    @csrf
                                    <button type="submit" class="px-3 py-2.5 rounded-xl bg-red-50 text-red-500 hover:bg-red-100 transition text-xs font-bold" title="Hapus Permanen">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </main>
    </div>

    <div id="userModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg relative z-10 overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalContent">

                <button onclick="closeModal()" class="absolute top-4 right-4 bg-black/10 hover:bg-black/20 text-white w-8 h-8 rounded-full flex items-center justify-center z-20 backdrop-blur transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <div id="modalBody"></div>
            </div>
        </div>
    </div>

    <script>
        const usersData = {!! json_encode($users) !!};

        function switchTab(tab) {
            const pendingBtn = document.getElementById('tab-pending');
            const approvedBtn = document.getElementById('tab-approved');
            const pendingContent = document.getElementById('content-pending');
            const approvedContent = document.getElementById('content-approved');

            if(tab === 'pending') {
                pendingBtn.classList.replace('tab-inactive', 'tab-active');
                approvedBtn.classList.replace('tab-active', 'tab-inactive');
                pendingBtn.style.backgroundColor = '#fff1f2'; approvedBtn.style.backgroundColor = 'transparent'; approvedBtn.style.color = '#94a3b8';
                pendingContent.classList.remove('hidden'); approvedContent.classList.add('hidden');
            } else {
                approvedBtn.classList.replace('tab-inactive', 'tab-active');
                pendingBtn.classList.replace('tab-active', 'tab-inactive');
                approvedBtn.style.backgroundColor = '#f0fdf4'; pendingBtn.style.backgroundColor = 'transparent'; approvedBtn.style.color = '#15803d'; approvedBtn.style.borderColor = '#15803d';
                approvedContent.classList.remove('hidden'); pendingContent.classList.add('hidden');
            }
        }

        function showDetail(id) {
            const user = usersData.find(u => u.id === id);
            if(!user) return;

            const modal = document.getElementById('userModal');
            const content = document.getElementById('modalContent');
            const body = document.getElementById('modalBody');

            let ageDisplay = '-';
            if (user.date_of_birth) {
                const birth = new Date(user.date_of_birth);
                const age = new Date().getFullYear() - birth.getFullYear();
                ageDisplay = age + ' Tahun';
            }

            const photoUrl = user.profile_photo_path
                ? `/storage/${user.profile_photo_path}`
                : `https://ui-avatars.com/api/?name=${encodeURI(user.name)}`;

            const isApproved = user.status === 'approved';

            body.innerHTML = `
                <div class="h-64 relative">
                    <img src="${photoUrl}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 text-white">
                        <h2 class="text-3xl font-black leading-tight">${user.name}</h2>
                        <div class="flex items-center gap-3 mt-2 text-sm font-medium opacity-90">
                            <span class="bg-white/20 backdrop-blur px-2 py-0.5 rounded-lg"><i class="fa-solid fa-cake-candles"></i> ${ageDisplay}</span>
                            <span class="bg-white/20 backdrop-blur px-2 py-0.5 rounded-lg"><i class="fa-solid fa-location-dot"></i> ${user.domisili}</span>
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100">
                            <p class="text-[10px] uppercase font-bold text-slate-400 mb-1">Gender</p>
                            <p class="font-bold text-slate-700 flex items-center gap-2">
                                ${user.gender == 'L' ? '<i class="fa-solid fa-mars text-blue-500"></i> Laki-laki' : '<i class="fa-solid fa-venus text-pink-500"></i> Perempuan'}
                            </p>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100">
                            <p class="text-[10px] uppercase font-bold text-slate-400 mb-1">Agama</p>
                            <p class="font-bold text-slate-700"><i class="fa-solid fa-hands-praying text-purple-500"></i> ${user.religion}</p>
                        </div>
                    </div>

                    ${user.whatsapp || user.instagram ? `
                    <div>
                        <p class="text-[10px] uppercase font-bold text-slate-400 mb-2">Kontak</p>
                        <div class="flex gap-3">
                            ${user.whatsapp ? `<a href="https://wa.me/${user.whatsapp}" target="_blank" class="flex-1 bg-green-100 text-green-700 py-2 rounded-xl text-xs font-bold text-center hover:bg-green-200"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>` : ''}
                            ${user.instagram ? `<a href="https://instagram.com/${user.instagram}" target="_blank" class="flex-1 bg-pink-100 text-pink-700 py-2 rounded-xl text-xs font-bold text-center hover:bg-pink-200"><i class="fa-brands fa-instagram"></i> Instagram</a>` : ''}
                        </div>
                    </div>` : ''}

                    <div class="border-t border-slate-100 pt-6 flex flex-col gap-3">
                        ${!isApproved ? `
                        <form action="/admin/users/${user.id}/approve" method="POST">
                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                            <button class="w-full py-3.5 rounded-xl bg-slate-900 text-white font-bold hover:bg-black transition shadow-xl shadow-slate-200">
                                <i class="fa-solid fa-check mr-2"></i> Terima User Ini
                            </button>
                        </form>` : ''}

                        <div class="flex gap-3">
                             <form action="/admin/users/${user.id}/reject" method="POST" class="flex-1">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                <button class="w-full py-3 rounded-xl border border-orange-200 text-orange-600 font-bold hover:bg-orange-50 transition text-sm">
                                    <i class="fa-solid fa-ban mr-1"></i> ${isApproved ? 'Blokir / Suspend' : 'Minta Revisi'}
                                </button>
                            </form>
                            <form action="/admin/users/${user.id}/delete" method="POST" class="flex-1" onsubmit="return confirm('Yakin Hapus?')">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                <button class="w-full py-3 rounded-xl border border-red-200 text-red-600 font-bold hover:bg-red-50 transition text-sm">
                                    <i class="fa-solid fa-trash mr-1"></i> Hapus Permanen
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            `;

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
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
        }
    </script>

    @if(session('success'))
    <script>
        const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
        Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
    </script>
    @endif
    @if(session('warning'))
    <script>
        const ToastW = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
        ToastW.fire({ icon: 'warning', title: '{{ session('warning') }}' });
    </script>
    @endif

</body>
</html>
