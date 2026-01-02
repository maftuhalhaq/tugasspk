<!DOCTYPE html>
<html lang="id">
<head>
    <title>Laporan User - BAMN AMORE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Nunito', sans-serif; background: #fff; color: #1e293b; }
        @media print {
            .no-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="p-8 max-w-5xl mx-auto">

    <div class="no-print mb-8 text-right">
        <button onclick="window.print()" class="bg-rose-500 hover:bg-rose-600 text-white font-bold py-2 px-6 rounded-full shadow-lg transition flex items-center gap-2 ml-auto">
            <i class="fa-solid fa-print"></i> Cetak Dokumen
        </button>
        <p class="text-xs text-gray-400 mt-2">Gunakan opsi "Save as PDF" di browser untuk menyimpan.</p>
    </div>

    <div class="flex items-center justify-between border-b-4 border-rose-500 pb-6 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-rose-500 rounded-2xl flex items-center justify-center text-white text-3xl shadow-lg">
                <i class="fa-solid fa-heart"></i>
            </div>
            <div>
                <h1 class="text-3xl font-black text-gray-800 tracking-tight">BAMN AMORE</h1>
                <p class="text-sm font-bold text-rose-500 uppercase tracking-widest">Laporan Data Pengguna</p>
            </div>
        </div>
        <div class="text-right text-sm text-gray-500">
            <p>Dicetak Oleh: <span class="font-bold text-gray-800">Admin</span></p>
            <p>Tanggal: <span class="font-bold text-gray-800">{{ now()->format('d F Y, H:i') }}</span></p>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6 mb-8">
        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
            <p class="text-xs text-gray-400 uppercase font-bold">Total User Aktif</p>
            <p class="text-2xl font-black text-rose-500">{{ $users->count() }}</p>
        </div>
        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
            <p class="text-xs text-gray-400 uppercase font-bold">Dominasi Gender</p>
            @php
                $pria = $users->where('gender', 'L')->count();
                $wanita = $users->where('gender', 'P')->count();
            @endphp
            <p class="text-xl font-bold text-gray-700">
                <i class="fa-solid fa-mars text-blue-500"></i> {{ $pria }}
                <span class="text-gray-300 mx-1">|</span>
                <i class="fa-solid fa-venus text-pink-500"></i> {{ $wanita }}
            </p>
        </div>
        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
            <p class="text-xs text-gray-400 uppercase font-bold">Rata-rata Gaji</p>
            <p class="text-xl font-bold text-green-600">
                Rp {{ number_format($users->avg('income_level'), 0, ',', '.') }}
            </p>
        </div>
    </div>

    <table class="w-full text-left text-sm border border-gray-200 rounded-lg overflow-hidden">
        <thead class="bg-gray-100 text-gray-600 font-bold uppercase text-xs">
            <tr>
                <th class="p-4 border-b border-gray-200">No</th>
                <th class="p-4 border-b border-gray-200">Nama Lengkap</th>
                <th class="p-4 border-b border-gray-200">L/P</th>
                <th class="p-4 border-b border-gray-200">Umur</th>
                <th class="p-4 border-b border-gray-200">Domisili</th>
                <th class="p-4 border-b border-gray-200">Agama</th>
                <th class="p-4 border-b border-gray-200 text-right">Penghasilan</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($users as $index => $u)
            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                <td class="p-4 text-gray-400 font-bold">{{ $loop->iteration }}</td>
                <td class="p-4 font-bold text-gray-800">{{ $u->name }}</td>
                <td class="p-4 font-bold {{ $u->gender == 'L' ? 'text-blue-500' : 'text-pink-500' }}">
                    {{ $u->gender }}
                </td>
                <td class="p-4 text-gray-600">
                    {{ \Carbon\Carbon::parse($u->date_of_birth)->age }} Th
                </td>
                <td class="p-4 text-gray-600">{{ $u->domisili }}</td>
                <td class="p-4 text-gray-600">{{ $u->religion }}</td>
                <td class="p-4 text-right font-mono font-bold text-green-600">
                    {{ number_format($u->income_level, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-12 flex justify-end">
        <div class="text-center w-48">
            <p class="text-xs text-gray-400 mb-16">Mengetahui, CEO BAMN AMORE</p>
            <p class="font-bold text-gray-800 border-b border-gray-300 pb-2">Maftuh Alhaq</p>
        </div>
    </div>

</body>
</html>
