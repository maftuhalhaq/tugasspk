<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Profil - Cupid AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen">

    <nav class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <span class="text-2xl">💘</span>
            <span class="font-bold text-gray-800">Cupid AI</span>
        </div>
        <a href="/cari-jodoh" class="text-sm text-gray-500 hover:text-blue-600 flex items-center gap-1 transition">
            &larr; Kembali ke Dashboard
        </a>
    </nav>

    <div class="max-w-2xl mx-auto py-10 px-4">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="bg-gradient-to-r from-gray-50 to-white p-8 border-b border-gray-100">
                <h1 class="text-2xl font-bold text-gray-900">Edit Profil Diri</h1>
                <p class="text-gray-500 text-sm mt-1">Perbarui data faktual Anda agar sistem dapat menemukan kecocokan yang akurat.</p>
            </div>

            <form action="/profil" method="POST" class="p-8 space-y-6">
                @csrf
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Jenis Kelamin</label>
                        <select name="gender" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="L" {{ $user->gender == 'L' ? 'selected' : '' }}>👨 Laki-laki</option>
                            <option value="P" {{ $user->gender == 'P' ? 'selected' : '' }}>👩 Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Agama</label>
                        <select name="religion" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'] as $rel)
                                <option value="{{ $rel }}" {{ $user->religion == $rel ? 'selected' : '' }}>{{ $rel }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Domisili (Kota/Kab)</label>
                    <input type="text" name="domisili" value="{{ $user->domisili }}" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="Contoh: Malang" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-green-600 uppercase mb-1">Penghasilan (Rupiah)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-bold text-sm">Rp</span>
                            <input type="number" name="real_income" value="{{ $user->income_level }}" class="w-full border border-gray-300 rounded-lg p-3 pl-10 text-sm focus:ring-2 focus:ring-green-500 outline-none font-bold text-gray-700" placeholder="0" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-blue-600 uppercase mb-1">Pendidikan Terakhir</label>
                        <select name="education_level" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="1" {{ $user->education_level == 1 ? 'selected' : '' }}>SMA / SMK</option>
                            <option value="2" {{ $user->education_level == 2 ? 'selected' : '' }}>Diploma (D3)</option>
                            <option value="3" {{ $user->education_level == 3 ? 'selected' : '' }}>Sarjana (S1)</option>
                            <option value="4" {{ $user->education_level == 4 ? 'selected' : '' }}>Magister (S2)</option>
                            <option value="5" {{ $user->education_level == 5 ? 'selected' : '' }}>Doktor (S3)</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3">
                    <a href="/cari-jodoh" class="px-6 py-2.5 rounded-lg text-sm font-bold text-gray-500 hover:bg-gray-100 transition">Batal</a>
                    <button type="submit" class="px-6 py-2.5 rounded-lg text-sm font-bold text-white bg-gray-900 hover:bg-black shadow-lg transition transform active:scale-95">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 1500,
            showConfirmButton: false
        });
    </script>
    @endif

</body>
</html>