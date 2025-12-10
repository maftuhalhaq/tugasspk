<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPreference;
use App\Models\Interaction; // Pastikan model Interaction sudah dibuat (jika belum, skip baris ini dulu)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MatchController extends Controller
{
    // ==========================================
    // 1. TAMPILKAN HASIL JODOH
    // ==========================================
    public function index()
    {
        $user = Auth::user();

        // Cek Data Diri
        if (!$user->gender || !$user->income_level)
            return redirect('/profil')->with('warning', 'Lengkapi profil dulu!');

        // Cek Kriteria
        $pref = UserPreference::where('user_id', $user->id)->first();
        if (!$pref)
            return redirect('/atur-kriteria')->with('warning', 'Atur kriteria dulu!');

        // --- A. QUERY DATABASE (FILTERING) ---
        $query = User::where('id', '!=', $user->id)
            ->where('gender', '!=', $user->gender)
            ->where('role', 'user'); // Hanya cari user biasa, bukan admin

        // 1. Filter Wajib (Strict Mode)
        if ($pref->strict_religion)
            $query->where('religion', $pref->preferred_religion);
        if ($pref->strict_domisili)
            $query->where('domisili', $pref->preferred_domisili);
        if ($pref->strict_income)
            $query->where('income_level', '>=', $pref->preferred_income_level);
        if ($pref->strict_education)
            $query->where('education_level', '>=', $pref->preferred_education_level);

        // 2. Filter Usia (Logic: Hitung Tahun Lahir)
        // Jika min_age 20 tahun, berarti lahir sebelum tahun (sekarang - 20)
        if ($pref->min_age) {
            $maxBirthDate = now()->subYears($pref->min_age)->format('Y-m-d');
            $query->where('date_of_birth', '<=', $maxBirthDate);
        }
        if ($pref->max_age) {
            $minBirthDate = now()->subYears($pref->max_age)->format('Y-m-d');
            $query->where('date_of_birth', '>=', $minBirthDate);
        }

        $allCandidates = $query->get();
        $gapMap = DB::table('gap_weights')->pluck('weight', 'gap')->toArray();
        $eduLabels = [1 => 'SMA/SMK', 2 => 'Diploma (D3)', 3 => 'Sarjana (S1)', 4 => 'Magister (S2)', 5 => 'Doktor (S3)'];

        // --- B. HITUNG SKOR SPK ---
        foreach ($allCandidates as $candidate) {

            // Hitung Bobot Criteria
            $isSameReligion = $candidate->religion == $pref->preferred_religion;
            $weightReligion = $isSameReligion ? 5.0 : 1.0;

            $isSameCity = strtolower($candidate->domisili) == strtolower($pref->preferred_domisili);
            $weightCity = $isSameCity ? 5.0 : 1.0;

            $selisih = abs($candidate->income_level - $pref->preferred_income_level);
            if ($selisih == 0)
                $weightIncome = 5.0;
            elseif ($selisih <= 1000000)
                $weightIncome = 4.5;
            elseif ($selisih <= 3000000)
                $weightIncome = 4.0;
            elseif ($selisih <= 5000000)
                $weightIncome = 3.0;
            elseif ($selisih <= 10000000)
                $weightIncome = 2.0;
            else
                $weightIncome = 1.0;

            $gapEdu = $candidate->education_level - $pref->preferred_education_level;
            $weightEdu = $gapMap[$gapEdu] ?? 1.0;

            // Hitung Total Skor
            $baseScore = ($weightReligion + $weightCity + $weightIncome + $weightEdu) / 4;

            // Bonus Sekufu
            $bonusScore = 0;
            $bonusReasons = [];
            if ($user->income_level >= $candidate->income_level) {
                $bonusScore += 0.25;
                $bonusReasons[] = "Penghasilanmu setara/lebih mapan (+0.25)";
            }
            if ($user->education_level >= $candidate->education_level) {
                $bonusScore += 0.25;
                $bonusReasons[] = "Pendidikanmu setara/lebih tinggi (+0.25)";
            }

            $finalScore = $baseScore + $bonusScore;
            $candidate->spk_score = number_format($finalScore, 2);
            $scoreVal = (float) $candidate->spk_score;

            // Data Breakdown (Untuk Popup)
            $candidate->score_breakdown = [
                'base' => number_format($baseScore, 2),
                'bonus' => $bonusScore > 0 ? "+" . $bonusScore : "0",
                'percent' => min(100, ($scoreVal / 5) * 100)
            ];

            $candidate->math_details = [
                'scores' => ['Agama' => $weightReligion, 'Kota' => $weightCity, 'Gaji' => $weightIncome, 'Pendidikan' => $weightEdu],
                'base_avg' => number_format($baseScore, 2),
                'bonus_total' => $bonusScore,
                'bonus_list' => $bonusReasons,
                'final_percent' => min(100, ($scoreVal / 5) * 100)
            ];

            // Tier & Visual
            if ($scoreVal >= 4.9) {
                $candidate->tier = 1;
                $candidate->match_label = "Jodoh Dunia Akhirat";
                $candidate->match_icon = "fa-solid fa-ring";
                $candidate->match_color = "from-rose-500 to-red-600";
            } elseif ($scoreVal >= 4.0) {
                $candidate->tier = 2;
                $candidate->match_label = "Si Paling Cocok";
                $candidate->match_icon = "fa-solid fa-heart-circle-check";
                $candidate->match_color = "from-pink-400 to-rose-500";
            } elseif ($scoreVal >= 3.0) {
                $candidate->tier = 3;
                $candidate->match_label = "Boleh Dicoba Nih";
                $candidate->match_icon = "fa-solid fa-face-grin-wink";
                $candidate->match_color = "from-purple-400 to-indigo-500";
            } else {
                $candidate->tier = 4;
                $candidate->match_label = "Temen Dulu Aja";
                $candidate->match_icon = "fa-solid fa-user-group";
                $candidate->match_color = "from-gray-400 to-slate-500";
            }

            // Tags
            $matchedTags = [];
            if ($isSameReligion)
                $matchedTags[] = ['icon' => 'fa-hands-praying', 'txt' => 'Seiman', 'col' => 'text-purple-600 bg-purple-50'];
            if ($isSameCity)
                $matchedTags[] = ['icon' => 'fa-location-dot', 'txt' => 'Sekota', 'col' => 'text-rose-600 bg-rose-50'];

            $diffGaji = $candidate->income_level - $pref->preferred_income_level;
            if ($diffGaji >= 0)
                $matchedTags[] = ['icon' => 'fa-money-bill-1-wave', 'txt' => 'Gaji Pas', 'col' => 'text-green-600 bg-green-50'];

            if ($candidate->education_level >= $pref->preferred_education_level)
                $matchedTags[] = ['icon' => 'fa-user-graduate', 'txt' => 'Pintar', 'col' => 'text-blue-600 bg-blue-50'];
            $candidate->matched_tags = $matchedTags;

            // Deskripsi (Text)
            $descriptions = [];
            $descriptions['agama'] = $isSameReligion ? "✅ Agama cocok ($candidate->religion)." : "❌ Agama beda ($candidate->religion).";
            $descriptions['kota'] = $isSameCity ? "✅ Domisili sama ($candidate->domisili)." : "❌ Kota beda ($candidate->domisili).";

            if ($diffGaji >= 0) {
                $lebih = number_format($diffGaji, 0, ',', '.');
                $descriptions['gaji'] = "✅ Gaji memenuhi target (Lebih Rp $lebih).";
            } else {
                $kurang = number_format(abs($diffGaji), 0, ',', '.');
                $descriptions['gaji'] = "⚠️ Gaji kurang Rp $kurang dari target.";
            }

            $candEduText = $eduLabels[$candidate->education_level] ?? '-';
            $descriptions['pendidikan'] = $candidate->education_level >= $pref->preferred_education_level
                ? "✅ Pendidikan oke ($candEduText)."
                : "❌ Pendidikan kurang ($candEduText).";

            $candidate->match_reason = $descriptions;

            // --- LINK WHATSAPP ---
            // Format 08123 -> 628123
            $hp = $candidate->whatsapp;
            if (substr($hp, 0, 1) == '0') {
                $hp = '62' . substr($hp, 1);
            }
            // Pesan Sapaan
            $salam = "Halo $candidate->name, salam kenal! Aku dapat profilmu dari Cupid AI.";
            $candidate->wa_link = "https://wa.me/$hp?text=" . urlencode($salam);
        }

        // --- C. SORTING & FINAL DECISION ---
        $sortedCandidates = $allCandidates->sortByDesc('spk_score');
        $topCandidate = $sortedCandidates->first();
        $isPerfectMatch = false;

        // SKENARIO 1: ZONK
        if ($sortedCandidates->isEmpty()) {
            $ghost = $this->createGhostCandidate($user); // Panggil fungsi helper
            $finalCandidates = collect([$ghost]);
            $status = "Waduh, kriteriamu terlalu tinggi bestie! Ini kami kasih simulasi aja ya.";
        }
        // SKENARIO 2: PERFECT MATCH
        elseif ($topCandidate && (float) $topCandidate->spk_score >= 4.9) {
            $finalCandidates = collect([$topCandidate]);
            $status = "Bingo! Kami menemukan 1 Kandidat Perfect Match Sesuai Kriteria Wajib!";
            $isPerfectMatch = true;
        }
        // SKENARIO 3: GRID (Top 6)
        else {
            $groupedByTier = $sortedCandidates->groupBy('tier');
            $finalCandidates = collect();
            foreach ($groupedByTier as $tier => $candidatesInTier) {
                $finalCandidates = $finalCandidates->merge($candidatesInTier->take(2));
            }
            $finalCandidates = $finalCandidates->take(6);
            $status = "Belum 100% Perfect, tapi ini rekomendasi terbaik buat kamu ✨";
        }

        return view('match_result', [
            'user' => $user,
            'status' => $status,
            'candidates' => $finalCandidates,
            'isPerfectMatch' => $isPerfectMatch
        ]);
    }

    // ==========================================
    // 2. HALAMAN FORM KRITERIA
    // ==========================================
    public function criteriaForm()
    {
        $user = Auth::user();
        $preference = UserPreference::where('user_id', $user->id)->first();
        return view('match_form', compact('user', 'preference'));
    }

    public function updateCriteria(Request $request)
    {
        $user = Auth::user();
        UserPreference::updateOrCreate(
            ['user_id' => $user->id],
            [
                'preferred_religion' => $request->preferred_religion,
                'preferred_domisili' => $request->preferred_domisili,
                'preferred_education_level' => $request->preferred_education_level,
                'preferred_income_level' => $request->preferred_real_income,
                'min_age' => $request->min_age ?? 18,
                'max_age' => $request->max_age ?? 50,
                'strict_religion' => $request->strict_religion ?? 0,
                'strict_domisili' => $request->strict_domisili ?? 0,
                'strict_income' => $request->strict_income ?? 0,
                'strict_education' => $request->strict_education ?? 0,
            ]
        );
        return redirect('/cari-jodoh')->with('success', 'Kriteria berhasil disimpan!');
    }

    // ==========================================
    // 3. REKAM INTERAKSI (AJAX)
    // ==========================================
    public function recordInteraction(Request $request, $id)
    {
        // Fitur ini untuk mencatat user yang klik tombol WA
        // Pastikan tabel 'interactions' sudah ada di database
        try {
            DB::table('interactions')->insert([
                'user_id' => Auth::id(),
                'target_id' => $id,
                'action_type' => 'whatsapp_click',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }

    // ==========================================
    // HELPER: DATA DUMMY (GHOST)
    // ==========================================
    // ==========================================
    // HELPER: DATA DUMMY (GHOST)
    // ==========================================
    private function createGhostCandidate($user)
    {
        $ghost = new \stdClass();
        $ghost->id = 99999;
        $ghost->name = "Jodoh Ghaib 👻";
        $ghost->gender = $user->gender == 'L' ? 'P' : 'L';
        $ghost->domisili = "Kayangan";
        $ghost->religion = "Malaikat";
        $ghost->income_level = 999999999999;
        $ghost->education_level = 5;
        $ghost->date_of_birth = now()->subYears(1000)->format('Y-m-d');

        // --- PERBAIKAN DISINI ---
        $ghost->profile_photo_path = null; // Agar tidak error undefined property
        $ghost->instagram = null;          // Agar tidak error undefined property
        // ------------------------

        $ghost->whatsapp = "62812345678";
        $ghost->wa_link = "#";

        $ghost->spk_score = "0.00";
        $ghost->match_label = "Spek Dewa / Dewi";
        $ghost->match_icon = "fa-solid fa-ghost";
        $ghost->match_color = "from-gray-700 to-black";

        $ghost->matched_tags = [
            ['icon' => 'fa-triangle-exclamation', 'txt' => 'Standar Ketinggian', 'col' => 'text-red-600 bg-red-100'],
            ['icon' => 'fa-face-dizzy', 'txt' => 'Ga Ada Orang', 'col' => 'text-orange-600 bg-orange-100']
        ];

        $ghost->score_breakdown = ['base' => 0, 'bonus' => 0, 'percent' => 0];

        $ghost->math_details = [
            'scores' => ['Agama' => 0, 'Kota' => 0, 'Gaji' => 0, 'Pendidikan' => 0],
            'base_avg' => 0,
            'bonus_total' => 0,
            'bonus_list' => [],
            'final_percent' => 0
        ];

        $ghost->match_reason = [
            'agama' => '❌ Mungkin dia alien',
            'kota' => '❌ Rumahnya belum dibangun',
            'gaji' => '⚠️ Gajinya pahala doang',
            'pendidikan' => '❌ Lulusan S3 (Sabar Selalu Sayang)'
        ];

        return $ghost;
    }
}