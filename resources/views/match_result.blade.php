<!DOCTYPE html>
<html lang="id">
<head>
    <title>Cupid AI - Find True Love</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #fff0f6; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #f9a8d4; border-radius: 10px; border: 2px solid #fff0f6; }
        
        .glass-panel { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); border: 2px solid rgba(255, 255, 255, 0.6); }
        .blob-anim { animation: blob-bounce 6s infinite ease-in-out; }
        @keyframes blob-bounce { 0%, 100% { transform: translateY(0) scale(1); } 50% { transform: translateY(-10px) scale(1.05); } }
        
        /* Shimmer Effect */
        .card-wrapper { position: relative; overflow: hidden; }
        .shimmer {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(to right, transparent 0%, rgba(255, 255, 255, 0.6) 50%, transparent 100%);
            transform: skewX(-20deg) translateX(-150%);
            transition: transform 0.5s; pointer-events: none; z-index: 20; mix-blend-mode: overlay;
        }
        .card-wrapper:hover .shimmer { animation: shimmer-anim 0.8s forwards; }
        @keyframes shimmer-anim { 100% { transform: skewX(-20deg) translateX(150%); } }

        /* Floating Hearts */
        .float-heart { position: absolute; bottom: -20px; opacity: 0; transition: all 0.5s; z-index: 15; pointer-events: none; }
        .card-wrapper:hover .float-heart { animation: floatUp 2s infinite ease-in-out; opacity: 1; }
        .float-heart:nth-child(1) { left: 10%; animation-delay: 0s; font-size: 1.2rem; color: #f43f5e; }
        .float-heart:nth-child(2) { left: 80%; animation-delay: 0.5s; font-size: 1rem; color: #ec4899; }
        .float-heart:nth-child(3) { left: 50%; animation-delay: 1s; font-size: 1.5rem; color: #e11d48; }
        @keyframes floatUp { 0% { transform: translateY(0) rotate(0deg); opacity: 0; } 50% { opacity: 1; } 100% { transform: translateY(-100px) rotate(20deg); opacity: 0; } }
    </style>
</head>
<body class="h-screen flex flex-col overflow-hidden text-gray-700">

    <header class="bg-white/90 backdrop-blur shadow-sm z-30 h-20 flex justify-between items-center px-8 border-b-2 border-pink-100 flex-shrink-0">
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-tr from-rose-400 to-pink-400 p-2.5 rounded-2xl shadow-lg text-white blob-anim">
                <i class="fa-solid fa-heart text-2xl"></i>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight leading-none">Cupid AI</h1>
                <p class="text-xs text-pink-500 font-bold uppercase tracking-widest">Sistem Pencarian Jodoh</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="hidden md:block text-right">
                <p class="text-xs text-gray-400 font-bold uppercase">Sedang Login</p>
                <p class="text-lg font-bold text-gray-800 leading-tight">{{ $user->name }}</p>
            </div>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="bg-white border-2 border-pink-200 hover:bg-rose-500 hover:text-white hover:border-rose-500 text-gray-600 text-sm px-6 py-2.5 rounded-full font-bold transition-all shadow-sm">
                    <i class="fa-solid fa-power-off mr-2"></i> Keluar
                </button>
            </form>
        </div>
    </header>

    <main class="flex-1 flex overflow-hidden relative">
        <div class="absolute top-20 left-10 w-80 h-80 bg-pink-300 rounded-full mix-blend-multiply filter blur-[80px] opacity-30 animate-blob"></div>
        <div class="absolute bottom-10 right-10 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-[80px] opacity-30 animate-blob animation-delay-2000"></div>

        <aside class="w-80 bg-white/70 border-r-2 border-pink-100 overflow-y-auto hidden md:flex flex-col z-10 glass-panel p-5 space-y-6">
            
            <div class="bg-white rounded-[2rem] p-5 shadow-sm border-2 border-white relative group transition-all hover:border-pink-200">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 bg-pink-100 rounded-full flex items-center justify-center text-3xl border-4 border-white shadow-md overflow-hidden">
                        @if($user->profile_photo_path)
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" class="w-full h-full object-cover">
                        @else
                            {{ $user->gender == 'L' ? '👦' : '👧' }}
                        @endif
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 truncate w-32">{{ $user->name }}</h2>
                        <span class="bg-pink-100 text-pink-600 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase">{{ $user->domisili }}</span>
                    </div>
                </div>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between p-2 bg-gray-50 rounded-lg">
                        <span class="text-gray-400 font-bold">Agama</span>
                        <span class="font-bold">{{ $user->religion }}</span>
                    </div>
                    <div class="flex justify-between p-2 bg-gray-50 rounded-lg">
                        <span class="text-gray-400 font-bold">Pendidikan</span>
                        <span class="font-bold">
                            @php 
                                $eduMap = [1=>'SMA/SMK', 2=>'Diploma (D3)', 3=>'Sarjana (S1)', 4=>'Magister (S2)', 5=>'Doktor (S3)'];
                                echo $eduMap[$user->education_level] ?? 'Level '.$user->education_level;
                            @endphp
                        </span>
                    </div>
                    <div class="flex justify-between p-2 bg-gray-50 rounded-lg">
                        <span class="text-gray-400 font-bold">Gaji</span>
                        <span class="font-bold text-green-600">Rp {{ number_format($user->income_level, 0, ',', '.') }}</span>
                    </div>
                </div>
                <a href="/profil" class="mt-3 w-full block text-center bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold py-2.5 rounded-xl transition"><i class="fa-solid fa-pen mr-1"></i> Edit Profil</a>
            </div>
            
            <div class="bg-white/80 rounded-[2rem] p-5 shadow-sm border-2 border-blue-50 relative">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                        <div class="bg-blue-100 p-1.5 rounded-lg text-blue-500"><i class="fa-solid fa-crosshairs"></i></div>
                        Kriteria Idaman
                    </h2>
                    <a href="/atur-kriteria" class="text-[10px] bg-blue-50 hover:bg-blue-500 hover:text-white text-blue-600 px-2 py-1 rounded-lg transition font-bold">
                        <i class="fa-solid fa-gear"></i> Ubah
                    </a>
                </div>

                @if($user->preference)
                <div class="space-y-3">
                    @php
                        $pEdu = $user->preference->preferred_education_level;
                        $eduLabel = $eduMap[$pEdu] ?? 'Level '.$pEdu;
                        $gajiLabel = 'Rp ' . number_format($user->preference->preferred_income_level, 0, ',', '.');
                    @endphp

                    @foreach([
                        ['label'=>'Agama', 'val'=>$user->preference->preferred_religion, 'strict'=>$user->preference->strict_religion, 'icon'=>'fa-hands-praying'],
                        ['label'=>'Kota', 'val'=>$user->preference->preferred_domisili, 'strict'=>$user->preference->strict_domisili, 'icon'=>'fa-map-location-dot'],
                        ['label'=>'Usia', 'val'=>$user->preference->min_age . ' - ' . $user->preference->max_age . ' Thn', 'strict'=>true, 'icon'=>'fa-cake-candles'],
                        ['label'=>'Min. Gaji', 'val'=>$gajiLabel, 'strict'=>$user->preference->strict_income, 'icon'=>'fa-sack-dollar'],
                        ['label'=>'Pendidikan', 'val'=>$eduLabel, 'strict'=>$user->preference->strict_education, 'icon'=>'fa-user-graduate'],
                    ] as $item)
                    
                    <div class="relative p-3 rounded-xl border-l-4 {{ $item['strict'] ? 'bg-red-50 border-red-400' : 'bg-blue-50 border-blue-300' }} shadow-sm">
                        <div class="absolute top-2 right-2">
                            @if($item['strict'])
                                <i class="fa-solid fa-lock text-red-400 text-xs" title="Syarat Wajib"></i>
                            @else
                                <i class="fa-regular fa-circle-check text-blue-400 text-xs" title="Opsional"></i>
                            @endif
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="text-lg {{ $item['strict'] ? 'text-red-400' : 'text-blue-400' }} w-6 text-center">
                                <i class="fa-solid {{ $item['icon'] }}"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase leading-none mb-1">{{ $item['label'] }}</p>
                                <p class="text-sm font-bold text-gray-700 leading-none truncate w-32">{{ $item['val'] }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-2 pt-1 border-t {{ $item['strict'] ? 'border-red-100' : 'border-blue-100' }}">
                            <p class="text-[9px] font-bold {{ $item['strict'] ? 'text-red-500' : 'text-blue-500' }}">
                                {{ $item['strict'] ? '⚠️ WAJIB' : '✨ OPSIONAL' }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </aside>

        <section class="flex-1 overflow-y-auto z-10 p-6 md:p-10 relative">
            <div class="max-w-6xl mx-auto h-full flex flex-col pb-20">
                
                <div class="mb-6 text-center md:text-left">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800 flex items-center justify-center md:justify-start gap-2">
                        Hasil Pencarian 
                        @if($isPerfectMatch) <span class="bg-rose-500 text-white text-xs px-3 py-1 rounded-full animate-bounce shadow-lg">PERFECT MATCH!</span> @endif
                    </h2>
                    <p class="text-base font-medium text-pink-500 mt-1">{{ $status }}</p>
                </div>

                @if($isPerfectMatch)
                    <div class="flex-1 flex items-center justify-center py-6">
                        <div class="w-full max-w-2xl bg-white rounded-[3rem] shadow-2xl shadow-rose-200 border-4 border-rose-100 relative overflow-hidden transform hover:scale-[1.01] transition duration-500 card-wrapper group">
                            <div class="shimmer"></div>
                            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/confetti.png')] opacity-10 animate-pulse"></div>
                            <div class="p-10 text-center relative z-10">
                                <div class="mb-6 inline-block relative">
                                    <div class="w-48 h-48 rounded-full border-8 border-rose-200 p-1 shadow-2xl bg-white overflow-hidden">
                                        @if($candidates->first()->profile_photo_path)
                                            <img src="{{ asset('storage/' . $candidates->first()->profile_photo_path) }}" class="w-full h-full object-cover rounded-full">
                                        @else
                                            <div class="w-full h-full rounded-full bg-gradient-to-tr from-pink-100 to-rose-50 flex items-center justify-center text-8xl">
                                                {{ $candidates->first()->gender == 'P' ? '👩' : '👨' }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="absolute -bottom-4 -right-4 bg-rose-500 text-white w-16 h-16 rounded-full flex items-center justify-center text-xl font-black border-4 border-white shadow-lg animate-bounce">
                                        5.0
                                    </div>
                                </div>
                                <h2 class="text-4xl font-black text-gray-800 mb-2">{{ $candidates->first()->name }}</h2>
                                
                                <p class="text-lg text-gray-500 font-bold mb-6 flex justify-center items-center gap-2">
                                    <span><i class="fa-solid fa-location-dot text-rose-500"></i> {{ $candidates->first()->domisili }}</span>
                                    <span class="text-gray-300">•</span>
                                    <span><i class="fa-solid fa-cake-candles text-rose-400"></i> {{ \Carbon\Carbon::parse($candidates->first()->date_of_birth)->age }} Tahun</span>
                                </p>
                                
                                <button onclick="document.getElementById('modal-{{ $candidates->first()->id }}').classList.remove('hidden')" 
                                    class="bg-gradient-to-r from-rose-500 to-pink-600 text-white text-lg font-extrabold py-4 px-12 rounded-full shadow-xl shadow-rose-300 hover:shadow-rose-400 transition transform hover:-translate-y-1 relative z-30 cursor-pointer">
                                    <i class="fa-solid fa-envelope-open-text mr-2"></i> Buka Rincian Lengkap
                                </button>
                            </div>
                        </div>
                    </div>

                @else
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 candidate-list">
                        @foreach($candidates as $candidate)
                        
                        <div class="card-wrapper bg-white rounded-[2.5rem] p-5 shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-pink-50 hover:border-pink-300 transition-all hover:-translate-y-2 group overflow-hidden">
                            
                            <div class="shimmer"></div>
                            <div class="float-heart"><i class="fa-solid fa-heart"></i></div>
                            <div class="float-heart"><i class="fa-solid fa-heart"></i></div>
                            <div class="float-heart"><i class="fa-solid fa-heart"></i></div>

                            <div class="absolute right-0 top-0 w-32 h-32 bg-gradient-to-br {{ $candidate->match_color }} opacity-10 rounded-bl-[100px] -z-0"></div>

                            <div class="flex flex-col gap-3 relative z-10">
                                <div class="flex items-start gap-4">
                                    <div class="relative">
                                        <div class="w-20 h-20 rounded-full bg-white flex items-center justify-center text-4xl border-4 border-pink-100 shadow-md transform group-hover:scale-110 transition duration-500 overflow-hidden">
                                            @if($candidate->profile_photo_path)
                                                <img src="{{ asset('storage/' . $candidate->profile_photo_path) }}" class="w-full h-full object-cover">
                                            @else
                                                {{ $candidate->gender == 'P' ? '👩' : '👨' }}
                                            @endif
                                        </div>
                                        <div class="absolute -bottom-2 -right-2 bg-gradient-to-r {{ $candidate->match_color }} text-white text-[10px] font-black px-2 py-1 rounded-lg border-2 border-white shadow-sm">
                                            {{ $candidate->spk_score }}
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0 pt-1">
                                        <div class="flex justify-between items-start">
                                            <h3 class="text-xl font-bold text-gray-800 truncate">{{ $candidate->name }}</h3>
                                            <span class="text-[9px] font-bold uppercase tracking-wider py-1 px-2 rounded-lg bg-white border border-gray-100 shadow-sm text-gray-600">
                                                <i class="{{ $candidate->match_icon }} mr-1 text-pink-500"></i> {{ str_replace(['🥰','💍','😉','😅'], '', $candidate->match_label) }}
                                            </span>
                                        </div>
                                        
                                        <p class="text-xs text-gray-500 font-bold mt-1 mb-2">
                                            {{ $candidate->domisili }} • {{ \Carbon\Carbon::parse($candidate->date_of_birth)->age }} Thn
                                        </p>
                                        
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                                <div class="bg-gradient-to-r {{ $candidate->match_color }} h-1.5 rounded-full" style="width: {{ $candidate->score_breakdown['percent'] }}%"></div>
                                            </div>
                                            <span class="text-[9px] font-bold text-gray-400">{{ round($candidate->score_breakdown['percent']) }}%</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white/60 p-2 rounded-xl border border-gray-100 flex flex-wrap gap-1.5">
                                    @if(count($candidate->matched_tags) > 0)
                                        @foreach(array_slice($candidate->matched_tags, 0, 2) as $tag)
                                            <span class="flex-1 inline-flex justify-center items-center gap-1.5 px-2 py-1.5 rounded-lg text-[10px] font-bold {{ $tag['col'] }} border border-white shadow-sm">
                                                <i class="fa-solid {{ $tag['icon'] }}"></i> {{ $tag['txt'] }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="w-full text-center text-[10px] text-gray-400 italic py-1.5">Kecocokan Parsial</span>
                                    @endif
                                </div>

                                <button onclick="document.getElementById('modal-{{ $candidate->id }}').classList.remove('hidden')" 
                                    class="w-full mt-1 bg-gray-900 hover:bg-black text-white text-sm font-bold py-3 rounded-2xl shadow-lg transition flex items-center justify-center gap-2 group relative z-30 cursor-pointer">
                                    <i class="fa-regular fa-eye group-hover:scale-110 transition"></i> Lihat Detail Lengkap
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif

                {{-- MODAL (POPUP) --}}
                @foreach($candidates as $candidate)
                <div id="modal-{{ $candidate->id }}" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-md transition-opacity" onclick="this.parentElement.classList.add('hidden')"></div>
                    
                    <div class="flex min-h-full items-center justify-center p-4">
                        <div class="relative w-full max-w-4xl bg-white rounded-[2.5rem] shadow-2xl overflow-hidden transform transition-all border-4 border-white flex flex-col md:flex-row">
                            
                            <button onclick="document.getElementById('modal-{{ $candidate->id }}').classList.add('hidden')" class="absolute top-4 right-4 z-20 bg-black/10 hover:bg-black/30 text-gray-600 hover:text-white w-10 h-10 rounded-full flex items-center justify-center transition backdrop-blur">
                                <i class="fa-solid fa-xmark text-xl"></i>
                            </button>

                            <div class="w-full md:w-2/5 bg-gradient-to-br from-pink-50 to-rose-50 p-8 flex flex-col items-center justify-center text-center">
                                <div class="w-36 h-36 rounded-full border-[6px] border-white bg-white shadow-xl flex items-center justify-center text-7xl mb-4 relative overflow-hidden">
                                    @if($candidate->profile_photo_path)
                                        <img src="{{ asset('storage/' . $candidate->profile_photo_path) }}" class="w-full h-full object-cover">
                                    @else
                                        {{ $candidate->gender == 'P' ? '👩' : '👨' }}
                                    @endif
                                </div>
                                <h3 class="text-2xl font-black text-gray-800 leading-tight mb-1">{{ $candidate->name }}</h3>
                                
                                {{-- REVISI UTAMA: UMUR DITAMPILKAN DI SINI DI POPUP --}}
                                <div class="flex items-center justify-center gap-2 mb-6">
                                    <span class="bg-white px-3 py-1 rounded-full shadow-sm text-sm font-bold text-rose-500 border border-rose-100 flex items-center gap-1">
                                        <i class="fa-solid fa-location-dot"></i> {{ $candidate->domisili }}
                                    </span>
                                    <span class="bg-white px-3 py-1 rounded-full shadow-sm text-sm font-bold text-gray-600 border border-gray-100 flex items-center gap-1">
                                        <i class="fa-solid fa-cake-candles text-pink-400"></i> {{ \Carbon\Carbon::parse($candidate->date_of_birth)->age }} Tahun
                                    </span>
                                </div>

                                <div class="w-full space-y-2">
                                    <div class="bg-white p-3 rounded-2xl shadow-sm flex items-center gap-3 text-left border border-blue-50">
                                        <div class="bg-blue-50 p-2 rounded-full text-blue-500"><i class="fa-solid fa-graduation-cap"></i></div>
                                        <div>
                                            <p class="text-[9px] uppercase font-bold text-gray-400">Pendidikan</p>
                                            <p class="font-bold text-gray-700 text-xs">
                                                @php echo $eduMap[$candidate->education_level] ?? '-'; @endphp
                                            </p>
                                        </div>
                                    </div>
                                    <div class="bg-white p-3 rounded-2xl shadow-sm flex items-center gap-3 text-left border border-green-50">
                                        <div class="bg-green-50 p-2 rounded-full text-green-500"><i class="fa-solid fa-wallet"></i></div>
                                        <div>
                                            <p class="text-[9px] uppercase font-bold text-gray-400">Penghasilan</p>
                                            <p class="font-bold text-gray-700 text-xs">Rp {{ number_format($candidate->income_level, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <div class="bg-white p-3 rounded-2xl shadow-sm flex items-center gap-3 text-left border border-purple-50">
                                        <div class="bg-purple-50 p-2 rounded-full text-purple-500"><i class="fa-solid fa-star-and-crescent"></i></div>
                                        <div>
                                            <p class="text-[9px] uppercase font-bold text-gray-400">Agama</p>
                                            <p class="font-bold text-gray-700 text-xs">{{ $candidate->religion }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full md:w-3/5 p-8 bg-white overflow-y-auto max-h-[80vh]">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $candidate->match_color }} text-white flex items-center justify-center text-xl shadow-lg">
                                        <i class="{{ $candidate->match_icon }}"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Status Hubungan</p>
                                        <h4 class="text-xl font-black text-gray-800">{{ str_replace(['🥰','💍','😉','😅'], '', $candidate->match_label) }}</h4>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-5 rounded-2xl border-2 border-dashed border-gray-300 mb-6 relative" style="background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 8px 8px;">
                                    <div class="absolute -top-3 left-4 bg-gray-800 text-white px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-md transform -rotate-2">
                                        🧾 Resep Perhitungan Cinta
                                    </div>
                                    
                                    <div class="space-y-1 text-xs mt-3 font-mono text-gray-600">
                                        <div class="flex justify-between"><span>Bobot Agama</span> <span class="font-bold">{{ number_format($candidate->math_details['scores']['Agama'], 1) }}</span></div>
                                        <div class="flex justify-between"><span>Bobot Kota</span> <span class="font-bold">{{ number_format($candidate->math_details['scores']['Kota'], 1) }}</span></div>
                                        <div class="flex justify-between"><span>Bobot Gaji</span> <span class="font-bold">{{ number_format($candidate->math_details['scores']['Gaji'], 1) }}</span></div>
                                        <div class="flex justify-between"><span>Bobot Pend</span> <span class="font-bold">{{ number_format($candidate->math_details['scores']['Pendidikan'], 1) }}</span></div>
                                        
                                        <div class="border-t border-gray-300 border-dashed my-2"></div>
                                        
                                        @if($candidate->math_details['bonus_total'] > 0)
                                            <div class="mt-2 p-2 bg-green-50 rounded border border-green-100">
                                                <div class="flex justify-between text-green-700 font-bold mb-1">
                                                    <span>🎁 Bonus Sekufu</span>
                                                    <span>+{{ $candidate->math_details['bonus_total'] }}</span>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="flex justify-between text-lg font-black items-center mt-2">
                                            <span class="text-gray-800 uppercase text-[10px]">Total Skor SPK</span>
                                            <span class="text-rose-500 bg-rose-50 px-2 rounded">{{ $candidate->spk_score }} / 5.0</span>
                                        </div>
                                        
                                        <div class="mt-1 text-[9px] text-gray-400 text-right">
                                            ( {{ $candidate->spk_score }} ÷ 5.0 ) x 100 = <span class="font-bold text-rose-500">{{ number_format($candidate->math_details['final_percent'], 0) }}% Match</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-2 mb-6">
                                    <h5 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Checklist Kecocokan</h5>
                                    @foreach(['agama', 'kota', 'gaji', 'pendidikan'] as $key)
                                        @if(isset($candidate->match_reason[$key]))
                                        <div class="flex gap-3 text-sm items-start bg-white p-2 rounded-lg border border-gray-50 hover:border-pink-100 transition">
                                            <div class="mt-0.5 min-w-[20px]">
                                                @if(str_contains($candidate->match_reason[$key], '✅')) <i class="fa-solid fa-circle-check text-green-500"></i>
                                                @elseif(str_contains($candidate->match_reason[$key], '⚠️')) <i class="fa-solid fa-circle-exclamation text-yellow-500"></i>
                                                @else <i class="fa-solid fa-circle-xmark text-red-400"></i> @endif
                                            </div>
                                            <p class="text-gray-600 leading-snug text-xs">{{ str_replace(['✅ ','❌ ','⚠️ '], '', $candidate->match_reason[$key]) }}</p>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="grid grid-cols-1 {{ $candidate->instagram ? 'sm:grid-cols-2' : '' }} gap-3 sticky bottom-0 bg-white pt-2">
                                    <a href="{{ $candidate->wa_link }}" target="_blank" onclick="recordInteraction({{ $candidate->id }})" 
                                       class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl shadow-lg shadow-green-100 transition flex justify-center items-center gap-2">
                                        <i class="fa-brands fa-whatsapp text-xl"></i> WhatsApp
                                    </a>
                                    @if($candidate->instagram)
                                        <a href="https://instagram.com/{{ str_replace('@', '', $candidate->instagram) }}" target="_blank" 
                                           class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold py-3 rounded-xl shadow-lg shadow-pink-100 transition flex justify-center items-center gap-2">
                                            <i class="fa-brands fa-instagram text-xl"></i> Instagram
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </section>
    </main>

    <script>
        function recordInteraction(candidateId) {
            if(candidateId === 99999) return;
            fetch('/record-interaction/' + candidateId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            }).catch(err => console.log('Gagal merekam interaksi:', err));
        }

        anime({
            targets: '.candidate-card',
            scale: [0.95, 1],
            opacity: [0, 1],
            delay: anime.stagger(150),
            easing: 'spring(1, 80, 10, 0)'
        });
    </script>
</body>
</html>