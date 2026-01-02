<!DOCTYPE html>
<html lang="id">
<head>
    <title>{{ $user->status == 'pending' ? 'Lengkapi Profil' : 'Edit Profil' }} - BAMN AMORE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #fff0f6; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #f9a8d4; border-radius: 10px; border: 2px solid #fff0f6; }

        /* Background Animasi */
        .blob-anim { animation: blob-bounce 6s infinite ease-in-out; }
        @keyframes blob-bounce { 0%, 100% { transform: translateY(0) scale(1); } 50% { transform: translateY(-10px) scale(1.05); } }

        /* Glass Effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 0.8);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col text-gray-700 relative">

    <header class="bg-white/90 backdrop-blur-md shadow-sm z-30 h-16 md:h-20 flex justify-between items-center px-4 md:px-8 border-b-2 border-pink-100 sticky top-0">
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-tr from-rose-400 to-pink-400 p-2 md:p-2.5 rounded-xl md:rounded-2xl shadow-lg text-white blob-anim">
                <i class="fa-solid fa-heart text-lg md:text-2xl"></i>
            </div>
            <div>
                <h1 class="text-lg md:text-2xl font-extrabold text-gray-800 tracking-tight leading-none">BAMN AMORE</h1>
                <p class="text-[9px] md:text-[10px] text-pink-500 font-bold uppercase tracking-widest hidden sm:block">
                    {{ $user->status == 'pending' ? 'Langkah 1: Data Diri' : 'Edit Profil' }}
                </p>
            </div>
        </div>

        @if($user->status == 'approved')
            <a href="/cari-jodoh" class="group bg-white border-2 border-pink-100 text-gray-400 hover:text-rose-500 hover:border-rose-200 hover:bg-rose-50 transition-all font-bold text-xs md:text-sm px-4 py-2 rounded-full flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-arrow-left text-sm group-hover:-translate-x-1 transition-transform duration-300"></i>
                <span>Kembali</span>
            </a>
        @else
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="text-xs font-bold text-gray-400 hover:text-rose-500 transition flex items-center gap-2">
                    <i class="fa-solid fa-power-off"></i> Keluar
                </button>
            </form>
        @endif
    </header>

    <main class="flex-1 container mx-auto px-4 py-8 md:py-12 max-w-3xl relative">

        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute top-40 left-10 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-[80px] opacity-30 animate-blob"></div>
            <div class="absolute bottom-20 right-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-[80px] opacity-30 animate-blob animation-delay-2000"></div>
        </div>

        <div class="glass-card rounded-[2rem] p-6 md:p-10 shadow-xl shadow-pink-100/50">

            @if($user->status == 'rejected')
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded-r-xl animate-pulse">
                <div class="flex items-center gap-3">
                    <div class="bg-red-100 p-2 rounded-full text-red-500"><i class="fa-solid fa-triangle-exclamation text-xl"></i></div>
                    <div>
                        <h3 class="font-bold text-red-700">Profilmu Ditolak Admin!</h3>
                        <p class="text-sm text-red-600 leading-tight mt-1">Mohon perbaiki data diri atau foto profil kamu agar terlihat jelas dan valid, lalu simpan ulang untuk diajukan kembali.</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="mb-8 border-b-2 border-dashed border-pink-100 pb-6 text-center md:text-left">
                <h1 class="text-2xl md:text-3xl font-black text-gray-800 mb-2 flex items-center justify-center md:justify-start gap-2">
                    <i class="fa-solid {{ $user->status == 'pending' ? 'fa-user-plus' : 'fa-user-pen' }} text-rose-500"></i>
                    {{ $user->status == 'rejected' ? 'Perbaiki Profil' : ($user->status == 'pending' ? 'Lengkapi Profil' : 'Edit Profil') }}
                </h1>
                <p class="text-sm text-gray-500 font-medium">
                    {{ $user->status == 'pending' ? 'Wajib isi foto dan data diri agar bisa diverifikasi Admin.' : 'Pastikan datamu selalu update ya!' }}
                </p>
            </div>

            <form action="/profil" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="flex flex-col items-center mb-6">
                    <div class="relative group cursor-pointer" onclick="document.getElementById('photoInput').click()">
                        @php
                            $photoUrl = $user->profile_photo_path
                                ? asset('storage/' . $user->profile_photo_path)
                                : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=fce7f3&color=db2777&size=256';
                        @endphp

                        <img id="photoPreview" src="{{ $photoUrl }}" class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-xl group-hover:opacity-75 transition duration-300 bg-white">

                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                            <i class="fa-solid fa-camera text-white text-3xl drop-shadow-md"></i>
                        </div>

                        <div class="absolute bottom-1 right-1 bg-rose-500 text-white p-2 rounded-full border-2 border-white shadow-md">
                            <i class="fa-solid fa-pencil text-xs"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2 font-bold uppercase tracking-wide">
                        {{ $user->status == 'pending' ? '*Wajib Upload Foto Asli' : 'Klik foto untuk mengganti' }}
                    </p>

                    <input type="file" name="photo" id="photoInput" class="hidden" accept="image/*" onchange="previewImage(event)">
                </div>

                <div class="group">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2 tracking-wider ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl p-4 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-rose-100 focus:border-rose-400 outline-none transition placeholder-gray-300" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2 tracking-wider ml-1">Tanggal Lahir</label>
                        <input type="date" name="date_of_birth" value="{{ $user->date_of_birth }}" class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl p-4 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-rose-100 focus:border-rose-400 outline-none transition" required>
                    </div>
                    <div class="group">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2 tracking-wider ml-1">Jenis Kelamin</label>
                        <div class="relative">
                            <select name="gender" class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl p-4 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-rose-100 focus:border-rose-400 outline-none appearance-none cursor-pointer hover:bg-white transition">
                                <option value="L" {{ $user->gender == 'L' ? 'selected' : '' }}>👨 Laki-laki</option>
                                <option value="P" {{ $user->gender == 'P' ? 'selected' : '' }}>👩 Perempuan</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2 tracking-wider ml-1">Domisili (Kota)</label>
                        <input type="text" name="domisili" value="{{ $user->domisili }}" class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl p-4 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-pink-100 focus:border-pink-400 outline-none transition placeholder-gray-300" placeholder="Contoh: Malang" required>
                    </div>
                    <div class="group">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2 tracking-wider ml-1">Agama</label>
                        <div class="relative">
                            <select name="religion" class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl p-4 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-purple-100 focus:border-purple-400 outline-none appearance-none cursor-pointer hover:bg-white transition">
                                @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'] as $rel)
                                    <option value="{{ $rel }}" {{ $user->religion == $rel ? 'selected' : '' }}>{{ $rel }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group">
                        <label class="block text-xs font-bold text-green-600 uppercase mb-2 tracking-wider ml-1">WhatsApp (Wajib)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-green-600 text-lg pointer-events-none"><i class="fa-brands fa-whatsapp"></i></span>
                            <input type="number" name="whatsapp" value="{{ $user->whatsapp }}" class="w-full bg-green-50 border-2 border-green-100 rounded-2xl p-4 pl-12 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-green-100 focus:border-green-400 outline-none transition placeholder-green-300" placeholder="628123456789" required>
                        </div>
                    </div>
                    <div class="group">
                        <label class="block text-xs font-bold text-pink-500 uppercase mb-2 tracking-wider ml-1">Instagram (Opsional)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-pink-500 text-lg pointer-events-none"><i class="fa-brands fa-instagram"></i></span>
                            <input type="text" name="instagram" value="{{ $user->instagram }}" class="w-full bg-pink-50 border-2 border-pink-100 rounded-2xl p-4 pl-12 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-pink-100 focus:border-pink-400 outline-none transition placeholder-pink-300" placeholder="username">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group">
                        <label class="block text-xs font-bold text-green-600 uppercase mb-2 tracking-wider ml-1">Penghasilan</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-green-600 font-extrabold text-sm pointer-events-none">Rp</span>
                            <input type="number" name="real_income" value="{{ $user->income_level }}" class="w-full bg-green-50/50 border-2 border-green-100 rounded-2xl p-4 pl-10 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-green-100 focus:border-green-400 outline-none transition placeholder-green-300" placeholder="0" required>
                        </div>
                    </div>
                    <div class="group">
                        <label class="block text-xs font-bold text-blue-500 uppercase mb-2 tracking-wider ml-1">Pendidikan</label>
                        <div class="relative">
                            <select name="education_level" class="w-full bg-blue-50/50 border-2 border-blue-100 rounded-2xl p-4 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-blue-100 focus:border-blue-400 outline-none appearance-none cursor-pointer hover:bg-white transition">
                                <option value="1" {{ $user->education_level == 1 ? 'selected' : '' }}>SMA / SMK</option>
                                <option value="2" {{ $user->education_level == 2 ? 'selected' : '' }}>Diploma (D3)</option>
                                <option value="3" {{ $user->education_level == 3 ? 'selected' : '' }}>Sarjana (S1)</option>
                                <option value="4" {{ $user->education_level == 4 ? 'selected' : '' }}>Magister (S2)</option>
                                <option value="5" {{ $user->education_level == 5 ? 'selected' : '' }}>Doktor (S3)</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-blue-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex flex-col-reverse md:flex-row items-center justify-end gap-3 md:gap-4">
                    @if($user->status == 'approved')
                    <a href="/cari-jodoh" class="w-full md:w-auto text-center px-6 py-3.5 rounded-2xl text-sm font-bold text-gray-500 hover:bg-gray-100 transition border border-transparent hover:border-gray-200">
                        Batal
                    </a>
                    @endif

                    <button type="submit" class="w-full md:w-auto bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white text-sm md:text-base font-extrabold py-3.5 px-8 rounded-2xl shadow-xl shadow-rose-200 transition transform hover:scale-105 active:scale-95 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        {{ $user->status == 'rejected' ? 'Simpan Perbaikan & Ajukan Ulang' : ($user->status == 'pending' ? 'Simpan & Ajukan Verifikasi' : 'Simpan Perubahan') }}
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('photoPreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        // Animasi Card
        anime({
            targets: '.glass-card',
            translateY: [20, 0],
            opacity: [0, 1],
            easing: 'spring(1, 80, 10, 0)',
            duration: 800
        });
    </script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false,
            background: '#fff',
            iconColor: '#f43f5e',
            customClass: { popup: 'rounded-[2rem]' }
        });
    </script>
    @endif

</body>
</html>
