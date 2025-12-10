<!DOCTYPE html>
<html lang="id">
<head>
    <title>Sistem Pencarian Jodoh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
    </style>
</head>
<body class="bg-gray-100 h-screen flex flex-col overflow-hidden">

    <header class="bg-white shadow-sm z-20 h-16 flex justify-between items-center px-8 border-b border-gray-200">
        <div class="flex items-center gap-3">
            <span class="text-3xl">💖</span>
            <div>
                <h1 class="text-xl font-bold text-gray-800 tracking-tight leading-none">Sistem Pencarian Jodoh</h1>
                <p class="text-[10px] text-gray-500 tracking-wider uppercase">SPK Profile Matching</p>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
            <div class="text-right hidden sm:block">
                <p class="text-xs text-gray-400 uppercase">Pengguna</p>
                <p class="text-sm font-bold text-gray-700">{{ $user->name }}</p>
            </div>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="bg-gray-100 hover:bg-red-50 text-gray-600 hover:text-red-600 text-xs px-4 py-2 rounded-full font-bold transition border border-gray-200">
                    Keluar
                </button>
            </form>
        </div>
    </header>

    <main class="flex-1 flex overflow-hidden">

        <aside class="w-full md:w-[30%] bg-white border-r border-gray-200 overflow-y-auto hidden md:flex flex-col">
            <div class="p-6 space-y-6">
                
                <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-5 border border-gray-200 shadow-sm relative overflow-hidden group">
                    <div class="flex justify-between items-center mb-4 relative z-10">
                        <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wide">Profil Saya</h2>
                        <a href="/profil" class="text-[10px] bg-white border border-gray-300 hover:border-blue-500 hover:text-blue-600 px-3 py-1 rounded-full transition shadow-sm font-semibold">
                            Edit Data
                        </a>
                    </div>
                    <div class="space-y-3 relative z-10">
                        <div>
                            <p class="text-xs text-gray-400">Nama Lengkap</p>
                            <p class="font-bold text-gray-800 text-lg leading-tight">{{ $user->name }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <p class="text-xs text-gray-400">Domisili</p>
                                <p class="font-semibold text-gray-700 text-sm">{{ $user->domisili }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Agama</p>
                                <p class="font-semibold text-gray-700 text-sm">{{ $user->religion }}</p>
                            </div>
                        </div>
                        <div class="pt-2 border-t border-gray-100">
                            <p class="text-xs text-gray-400 mb-1">Status Ekonomi</p>
                            <div class="flex justify-between items-center">
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-bold">
                                    Rp {{ number_format($user->income_level, 0, ',', '.') }}
                                </span>
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold">
                                    @php $l=$user->education_level; @endphp
                                    {{ $l==1?'SMA':($l==2?'D3':($l==3?'S1':($l==4?'S2':'S3'))) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-white rounded-2xl p-5 border border-blue-100 shadow-sm relative overflow-hidden">
                     <div class="flex justify-between items-center mb-4">
                        <h2 class="text-sm font-bold text-blue-500 uppercase tracking-wide">Kriteria Idaman</h2>
                        <a href="/atur-kriteria" class="text-[10px] bg-white border border-blue-200 hover:bg-blue-600 hover:text-white text-blue-600 px-3 py-1 rounded-full transition shadow-sm font-semibold">
                            Atur Ulang
                        </a>
                    </div>

                    @if($user->preference)
                    <div class="space-y-2">
                        @foreach([
                            ['label'=>'Agama', 'val'=>$user->preference->preferred_religion, 'strict'=>$user->preference->strict_religion],
                            ['label'=>'Kota', 'val'=>$user->preference->preferred_domisili, 'strict'=>$user->preference->strict_domisili],
                            ['label'=>'Pendidikan', 'val'=>($user->preference->preferred_education_level==1?'SMA':($user->preference->preferred_education_level==2?'D3':($user->preference->preferred_education_level==3?'S1':($user->preference->preferred_education_level==4?'S2':'S3')))), 'strict'=>$user->preference->strict_education],
                        ] as $item)
                        <div class="flex justify-between items-center bg-white p-2 rounded-lg border border-blue-50">
                            <div>
                                <p class="text-[10px] text-gray-400">{{ $item['label'] }}</p>
                                <p class="text-sm font-bold text-gray-700">{{ $item['val'] }}</p>
                            </div>
                            @if($item['strict'])
                                <span class="text-[9px] bg-red-100 text-red-600 px-1.5 py-0.5 rounded uppercase font-bold tracking-wider">Wajib</span>
                            @else
                                <span class="text-[9px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded uppercase font-bold tracking-wider">Opsional</span>
                            @endif
                        </div>
                        @endforeach

                        <div class="bg-white p-2 rounded-lg border border-blue-50 mt-1">
                            <div class="flex justify-between">
                                <p class="text-[10px] text-gray-400">Min. Gaji</p>
                                @if($user->preference->strict_income)
                                    <span class="text-[9px] bg-red-100 text-red-600 px-1.5 py-0.5 rounded uppercase font-bold tracking-wider">Wajib</span>
                                @else
                                    <span class="text-[9px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded uppercase font-bold tracking-wider">Opsional</span>
                                @endif
                            </div>
                            <p class="text-sm font-bold text-blue-600">Rp {{ number_format($user->preference->preferred_income_level, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @else
                        <div class="text-center py-4 text-gray-400 text-xs italic">Belum ada kriteria.</div>
                    @endif
                </div>
            </div>
        </aside>

        <section class="w-full md:w-[70%] bg-gray-50 overflow-y-auto relative">
            
            <div class="sticky top-0 bg-gray-50/95 backdrop-blur z-10 px-8 py-6 border-b border-gray-200 flex justify-between items-end">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Rekomendasi Kandidat</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $status }}</p>
                </div>
                <div class="bg-white px-4 py-1.5 rounded-full border border-gray-200 shadow-sm text-xs font-medium text-gray-600">
                    Ditemukan: <span class="text-blue-600 font-bold">{{ $candidates->count() }}</span>
                </div>
            </div>

            <div class="p-8 pb-20">
                <div class="grid grid-cols-1 gap-6"> 
                    @foreach($candidates as $candidate)
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col md:flex-row">
                        
                        <div class="p-6 flex-1">
                            
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 leading-tight">{{ $candidate->name }}</h3>
                                    <div class="text-sm text-gray-500 mt-1 flex gap-2">
                                        <span class="bg-gray-100 px-2 py-0.5 rounded text-xs">{{ $candidate->domisili }}</span>
                                        <span class="bg-gray-100 px-2 py-0.5 rounded text-xs">{{ $candidate->religion }}</span>
                                        <span class="bg-gray-100 px-2 py-0.5 rounded text-xs">{{ \Carbon\Carbon::parse($candidate->date_of_birth)->age }} Tahun</span>
                                    </div>
                                </div>

                                <button onclick="document.getElementById('modal-{{ $candidate->id }}').classList.remove('hidden')" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-sm flex items-center gap-1">
                                    📄 Lihat Profil Lengkap
                                </button>
                            </div>

                            <div class="mt-4 flex flex-wrap gap-3">
                                <div class="flex items-center gap-2 bg-green-50 text-green-700 px-3 py-1.5 rounded-lg border border-green-100">
                                    <span>💰</span>
                                    <span class="font-bold text-sm">Rp {{ number_format($candidate->income_level/1000000, 1) }} Jt</span>
                                </div>
                                <div class="flex items-center gap-2 bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg border border-blue-100">
                                    <span>🎓</span>
                                    <span class="font-bold text-sm">
                                        @php $p = $candidate->education_level; @endphp
                                        {{ $p==1?'SMA': ($p==2?'D3': ($p==3?'S1': ($p==4?'S2':'S3'))) }}
                                    </span>
                                </div>
                            </div>

                            <details class="mt-5 group border-t border-gray-100 pt-3">
                                <summary class="text-xs font-semibold text-blue-600 cursor-pointer hover:text-blue-800 flex items-center gap-1 select-none transition">
                                    <span class="group-open:rotate-90 transition-transform text-[10px]">▶</span>
                                    Lihat Alasan Kecocokan
                                </summary>
                                <div class="mt-2 pl-4 text-xs text-gray-600 space-y-1 bg-gray-50 p-3 rounded-lg border border-gray-200">
                                    @foreach(['gaji', 'pendidikan', 'agama', 'kota'] as $key)
                                        @if(isset($candidate->match_reason[$key]))
                                        <div class="flex gap-2">
                                            <span>
                                                @if(str_contains($candidate->match_reason[$key], '✅')) ✅
                                                @elseif(str_contains($candidate->match_reason[$key], '⚠️')) ⚠️
                                                @else ❌ @endif
                                            </span>
                                            <span>{{ str_replace(['✅ ','❌ ','⚠️ '], '', $candidate->match_reason[$key]) }}</span>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </details>
                        </div>

                        <div class="bg-gray-50 p-6 flex flex-col items-center justify-center min-w-[140px] border-l border-gray-100 text-center">
                            <span class="text-[10px] text-gray-400 uppercase tracking-wider font-bold mb-1">Kecocokan</span>
                            <span class="text-5xl font-black {{ $candidate->spk_score >= 4.5 ? 'text-green-500' : ($candidate->spk_score >= 3.0 ? 'text-blue-500' : 'text-gray-400') }}">
                                {{ $candidate->spk_score }}
                            </span>
                            
                            <span class="mt-2 px-3 py-1 text-[10px] font-bold rounded-full
                                {{ $candidate->spk_score >= 4.5 ? 'bg-green-100 text-green-700' : ($candidate->spk_score >= 3.0 ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-600') }}">
                                @if($candidate->spk_score >= 4.5) Sangat Cocok
                                @elseif($candidate->spk_score >= 3.0) Cukup Cocok
                                @else Kurang @endif
                            </span>
                        </div>

                    </div>

                    <div id="modal-{{ $candidate->id }}" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
                        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-gray-200">
                                
                                <div class="h-32 {{ $candidate->gender == 'P' ? 'bg-gradient-to-r from-pink-400 to-rose-500' : 'bg-gradient-to-r from-blue-400 to-indigo-500' }}">
                                    <button onclick="document.getElementById('modal-{{ $candidate->id }}').classList.add('hidden')" class="absolute top-4 right-4 bg-black/20 hover:bg-black/40 text-white rounded-full p-1.5 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                                
                                <div class="px-6 pb-6">
                                    <div class="relative -mt-12 mb-4 flex justify-between items-end">
                                        <div class="h-24 w-24 rounded-full border-4 border-white bg-white shadow-lg flex items-center justify-center text-5xl">
                                            {{ $candidate->gender == 'P' ? '👩' : '👨' }}
                                        </div>
                                        <div class="text-right mb-2">
                                            <p class="text-xs text-gray-400 uppercase tracking-widest font-bold">Kecocokan</p>
                                            <p class="text-4xl font-black {{ $candidate->spk_score >= 4.5 ? 'text-green-500' : 'text-blue-600' }}">
                                                {{ $candidate->spk_score }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mb-6">
                                        <h3 class="text-2xl font-bold text-gray-900">{{ $candidate->name }}</h3>
                                        <p class="text-gray-500 text-sm flex items-center gap-2">
                                            <span>📍 {{ $candidate->domisili }}</span><span>•</span><span>{{ $candidate->religion }}</span><span>•</span><span>{{ \Carbon\Carbon::parse($candidate->date_of_birth)->age }} Tahun</span>
                                        </p>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-4">
                                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wide border-b pb-1">Data Faktual</h4>
                                            <div class="grid grid-cols-2 gap-3">
                                                <div class="bg-gray-50 p-2.5 rounded-lg">
                                                    <p class="text-[10px] text-gray-400">Pendidikan</p>
                                                    <p class="font-bold text-gray-700 text-sm">
                                                        @php $p=$candidate->education_level; @endphp
                                                        {{ $p==1?'SMA': ($p==2?'D3': ($p==3?'S1': ($p==4?'S2':'S3'))) }}
                                                    </p>
                                                </div>
                                                <div class="bg-green-50 p-2.5 rounded-lg border border-green-100">
                                                    <p class="text-[10px] text-green-600">Penghasilan</p>
                                                    <p class="font-bold text-green-700 text-sm">
                                                        Rp {{ number_format($candidate->income_level/1000000, 1) }} Jt
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="pt-2">
                                                <button class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl shadow-md transition flex items-center justify-center gap-2">
                                                    <span>💬</span> Chat via WhatsApp
                                                </button>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wide border-b border-gray-200 pb-2 mb-3">Analisis Kecocokan</h4>
                                            <div class="space-y-3 text-xs text-gray-600">
                                                 @foreach(['gaji', 'pendidikan', 'agama', 'kota'] as $key)
                                                    @if(isset($candidate->match_reason[$key]))
                                                    <div class="flex gap-2 items-start">
                                                        <div class="mt-0.5 min-w-[16px]">
                                                            @if(str_contains($candidate->match_reason[$key], '✅')) <span class="text-green-500">✔</span>
                                                            @elseif(str_contains($candidate->match_reason[$key], '⚠️')) <span class="text-yellow-500">⚡</span>
                                                            @else <span class="text-red-500">✖</span> @endif
                                                        </div>
                                                        <p>{{ str_replace(['✅ ','❌ ','⚠️ '], '', $candidate->match_reason[$key]) }}</p>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if($candidates->isEmpty())
                    <div class="col-span-full text-center py-20">
                         <div class="text-6xl mb-4 grayscale opacity-30">💘</div>
                        <h3 class="text-lg font-bold text-gray-500">Belum ada kandidat yang pas.</h3>
                    </div>
                    @endif
                </div>
            </div>
        </section>

    </main>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
    @endif

</body>
</html>