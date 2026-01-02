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
        if (!$user->gender || !$user->income_level) return redirect('/profil')->with('warning', 'Lengkapi profil dulu!');

        $pref = UserPreference::where('user_id', $user->id)->first();
        if (!$pref) return redirect('/atur-kriteria')->with('warning', 'Atur kriteria dulu!');

        // --- 1. LOAD SETTINGS (OTAK DINAMIS) ---
        $jsonPath = storage_path('app/spk_settings.json');

        // Default Config (Jika file belum ada)
        $defaults = [
            'income_ranges' => [
                ['limit' => 0, 'weight' => 5.0],
                ['limit' => 500000, 'weight' => 4.5],
                ['limit' => 1000000, 'weight' => 4.0],
                ['limit' => 3000000, 'weight' => 3.0],
                ['limit' => 5000000, 'weight' => 2.0],
                ['limit' => 10000000, 'weight' => 1.0],
            ],
            // Config Baru (Requestmu: Semua bisa diedit)
            'points' => [
                'rel_match' => 5.0, 'rel_mismatch' => 1.0,
                'loc_match' => 5.0, 'loc_mismatch' => 1.0,
                'bonus_income' => 0.25, 'bonus_edu' => 0.25
            ]
        ];

        $settings = file_exists($jsonPath) ? json_decode(file_get_contents($jsonPath), true) : $defaults;

        $incRanges = $settings['income_ranges'] ?? $defaults['income_ranges'];
        $pts = array_merge($defaults['points'], $settings['points'] ?? []); // Merge biar aman

        // --- 2. FILTERING DATA ---
        $query = User::where('id', '!=', $user->id)->where('gender', '!=', $user->gender)->where('role', 'user');

        if ($pref->strict_religion) $query->where('religion', $pref->preferred_religion);
        if ($pref->strict_domisili) $query->where('domisili', $pref->preferred_domisili);
        if ($pref->strict_income) $query->where('income_level', '>=', $pref->preferred_income_level);
        if ($pref->strict_education) $query->where('education_level', '>=', $pref->preferred_education_level);

        if ($pref->min_age) $query->where('date_of_birth', '<=', now()->subYears($pref->min_age)->format('Y-m-d'));
        if ($pref->max_age) $query->where('date_of_birth', '>=', now()->subYears($pref->max_age)->format('Y-m-d'));

        $allCandidates = $query->get();

        // Ambil Bobot GAP Pendidikan (DB) & Bobot Prioritas Slider (DB)
        $gapMap = DB::table('gap_weights')->pluck('weight', 'gap')->toArray();
        $criteria = DB::table('criteria_weights')->pluck('weight', 'name')->toArray();

        // Fallback jika DB kosong
        $wRel = $criteria['religion'] ?? 0.25;
        $wCity = $criteria['domisili'] ?? 0.25;
        $wIncome = $criteria['income'] ?? 0.25;
        $wEdu = $criteria['education'] ?? 0.25;

        // --- 3. HITUNG SKOR (CORE ENGINE) ---
        foreach ($allCandidates as $candidate) {

            // A. Agama (Pakai Config Admin)
            $isSameRel = $candidate->religion == $pref->preferred_religion;
            $valReligion = $isSameRel ? $pts['rel_match'] : $pts['rel_mismatch'];

            // B. Lokasi (Pakai Config Admin)
            $isSameLoc = strtolower($candidate->domisili) == strtolower($pref->preferred_domisili);
            $valCity = $isSameLoc ? $pts['loc_match'] : $pts['loc_mismatch'];

            // C. Penghasilan (Dynamic Ranges)
            $selisih = abs($candidate->income_level - $pref->preferred_income_level);
            $valIncome = 1.0; // Default terendah
            foreach ($incRanges as $range) {
                if ($selisih <= $range['limit']) {
                    $valIncome = $range['weight'];
                    break;
                }
            }

            // D. Pendidikan (Gap Mapping dari DB)
            $gapEdu = abs($candidate->education_level - $pref->preferred_education_level);
            $valEdu = $gapMap[$gapEdu] ?? 1.0;

            // TOTAL WEIGHTED SUM
            $baseScore = ($valReligion * $wRel) + ($valCity * $wCity) + ($valIncome * $wIncome) + ($valEdu * $wEdu);

            // BONUS POINTS (Pakai Config Admin)
            $bonusScore = 0;
            if ($user->income_level >= $candidate->income_level) $bonusScore += $pts['bonus_income'];
            if ($user->education_level >= $candidate->education_level) $bonusScore += $pts['bonus_edu'];

            $candidate->spk_score = number_format($baseScore + $bonusScore, 2);
            $valFinal = (float) $candidate->spk_score;

            // Tiering & Visual (Tetap sama)
            if ($valFinal >= 4.9) { $candidate->tier = 1; $candidate->match_label = "Jodoh Dunia Akhirat"; $candidate->match_icon = "fa-solid fa-ring"; $candidate->match_color = "from-rose-500 to-red-600"; }
            elseif ($valFinal >= 4.0) { $candidate->tier = 2; $candidate->match_label = "Si Paling Cocok"; $candidate->match_icon = "fa-solid fa-heart-circle-check"; $candidate->match_color = "from-pink-400 to-rose-500"; }
            elseif ($valFinal >= 3.0) { $candidate->tier = 3; $candidate->match_label = "Boleh Dicoba"; $candidate->match_icon = "fa-solid fa-face-grin-wink"; $candidate->match_color = "from-purple-400 to-indigo-500"; }
            else { $candidate->tier = 4; $candidate->match_label = "Temen Aja"; $candidate->match_icon = "fa-solid fa-user-group"; $candidate->match_color = "from-gray-400 to-slate-500"; }

            // Debugging Data (Untuk Popup)
            $candidate->math_details = [
                'val_rel' => $valReligion,
                'val_loc' => $valCity,
                'val_inc' => $valIncome,
                'val_edu' => $valEdu,
                'bonus' => $bonusScore
            ];

            // Link WA
            $hp = $candidate->whatsapp; if (substr($hp, 0, 1) == '0') $hp = '62' . substr($hp, 1);
            $candidate->wa_link = "https://wa.me/$hp";
        }

        $sortedCandidates = $allCandidates->sortByDesc('spk_score');

        return view('match_result', [
            'user' => $user,
            'status' => $sortedCandidates->isEmpty() ? "Belum ada calon nih." : "Rekomendasi Terbaik",
            'candidates' => $sortedCandidates->take(6),
            'isPerfectMatch' => ($sortedCandidates->first() && (float)$sortedCandidates->first()->spk_score >= 4.9)
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
