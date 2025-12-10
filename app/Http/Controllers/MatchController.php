<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MatchController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user->gender || !$user->income_level)
            return redirect('/profil');

        $pref = UserPreference::where('user_id', $user->id)->first();
        if (!$pref)
            return redirect('/atur-kriteria');

        $gapMap = DB::table('gap_weights')->pluck('weight', 'gap')->toArray();
        $eduLabels = [1 => 'SMA', 2 => 'D3', 3 => 'S1', 4 => 'S2', 5 => 'S3'];

        // 1. FILTERING
        $query = User::where('id', '!=', $user->id)
            ->where('gender', '!=', $user->gender)
            ->where('role', 'user');

        if ($pref->strict_religion)
            $query->where('religion', $pref->preferred_religion);
        if ($pref->strict_domisili)
            $query->where('domisili', $pref->preferred_domisili);
        if ($pref->strict_income)
            $query->where('income_level', '>=', $pref->preferred_income_level);
        if ($pref->strict_education)
            $query->where('education_level', '>=', $pref->preferred_education_level);

        $candidates = $query->get();
        $status = "Hasil Pencarian (Sesuai Filter)";

        if ($candidates->isEmpty()) {
            $status = "Alternatif (Filter Dilepas)";
            $candidates = User::where('id', '!=', $user->id)
                ->where('gender', '!=', $user->gender)
                ->where('role', 'user')
                ->get();
        }

        // 2. SCORING
        foreach ($candidates as $candidate) {
            // ... (Kode hitung skor baseScore & bonusScore sama seperti sebelumnya) ...

            // Hitung Gap & Bobot disini (sama seperti sebelumnya)...
            // AGAMA
            $isSameReligion = $candidate->religion == $pref->preferred_religion;
            $weightReligion = $isSameReligion ? 5.0 : 1.0;
            // KOTA
            $isSameCity = strtolower($candidate->domisili) == strtolower($pref->preferred_domisili);
            $weightCity = $isSameCity ? 5.0 : 1.0;
            // GAJI
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
            // PENDIDIKAN
            $gapEdu = $candidate->education_level - $pref->preferred_education_level;
            $weightEdu = $gapMap[$gapEdu] ?? 1.0;

            $baseScore = ($weightReligion + $weightCity + $weightIncome + $weightEdu) / 4;
            $bonusScore = 0;
            if ($user->income_level >= $candidate->income_level)
                $bonusScore += 0.25;
            if ($user->education_level >= $candidate->education_level)
                $bonusScore += 0.25;

            $candidate->spk_score = number_format($baseScore + $bonusScore, 2);

            // DESKRIPSI
            $descriptions = [];
            $descriptions['agama'] = $isSameReligion ? "✅ Anda memiliki kecocokan agama ($candidate->religion)." : "❌ Agama berbeda ($candidate->religion).";
            $descriptions['kota'] = $isSameCity ? "✅ Anda memiliki kecocokan kota ($candidate->domisili)." : "❌ Kota berbeda ($candidate->domisili).";
            if ($selisih == 0)
                $descriptions['gaji'] = "✅ Gaji persis sama dengan target.";
            elseif ($selisih <= 1000000)
                $descriptions['gaji'] = "✅ Gaji sangat mendekati target.";
            elseif ($candidate->income_level > $pref->preferred_income_level)
                $descriptions['gaji'] = "✅ Gaji di atas target minimal.";
            else
                $descriptions['gaji'] = "⚠️ Gaji lebih rendah Rp " . number_format($selisih, 0, ',', '.');

            $candEdu = $eduLabels[$candidate->education_level] ?? '-';
            $descriptions['pendidikan'] = $candidate->education_level >= $pref->preferred_education_level ? "✅ Pendidikan cocok ($candEdu)." : "❌ Pendidikan masih kurang ($candEdu).";

            $candidate->match_reason = $descriptions;
            $candidate->debug_info = ['bonus_diri' => "+ $bonusScore"]; // Minimal data debug
        }

        // 3. RANKING & WINNER TAKES ALL
        $rankedCandidates = $candidates->sortByDesc('spk_score');
        $top = $rankedCandidates->first();

        if ($top && (float) $top->spk_score >= 5.0) {
            $rankedCandidates = collect([$top]);
            $status = "Ditemukan 1 Perfect Match!";
        }

        return view('match_result', [
            'user' => $user,
            'status' => $status,
            'candidates' => $rankedCandidates
        ]);
    }

    // 1. Tampilkan Halaman Form
    public function edit()
    {
        // Ambil user yg login (sementara hardcode ID 1 Budi)
        $user = Auth::user() ?? User::find(1);

        // Ambil preferensi yg sudah ada (biar form terisi otomatis)
        $preference = UserPreference::where('user_id', $user->id)->first();

        return view('match_form', compact('user', 'preference'));
    }

    // 2. Simpan Data Form ke Database
    public function update(Request $request)
    {
        $user = Auth::user();

        // Simpan Data termasuk status strict
        UserPreference::updateOrCreate(
            ['user_id' => $user->id],
            [
                'preferred_religion' => $request->preferred_religion,
                'preferred_domisili' => $request->preferred_domisili,
                'preferred_education_level' => $request->preferred_education_level,
                'preferred_income_level' => $request->preferred_real_income,

                // SIMPAN STATUS WAJIB/TIDAK
                'strict_religion' => $request->strict_religion,
                'strict_domisili' => $request->strict_domisili,
                'strict_income' => $request->strict_income,
                'strict_education' => $request->strict_education,
            ]
        );

        return redirect('/cari-jodoh')->with('success', 'Aturan pencarian berhasil diperbarui!');
    }

    // --- FITUR BARU: EDIT PROFIL DIRI (FAKTA) ---

    // 1. Form Edit Profil
    public function editProfile()
    {
        $user = Auth::user() ?? User::find(1);
        return view('profile_edit', compact('user'));
    }

    // 2. Simpan Perubahan Profil
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi
        $request->validate([
            'name' => 'required|string',
            'domisili' => 'required|string',
            'education_level' => 'required|integer',
            'religion' => 'required',
            'gender' => 'required',
            'real_income' => 'required|numeric|min:0',
        ]);

        // 2. Update Data
        $user->update([
            'name' => $request->name,
            'domisili' => $request->domisili,
            'education_level' => $request->education_level,
            'religion' => $request->religion,
            'gender' => $request->gender,
            'income_level' => $request->real_income,
        ]);

        // --- LOGIKA REDIRECT (PERBAIKAN) ---

        // Cek dulu: Apakah dia sudah punya Kriteria Pencarian?
        $hasPreference = UserPreference::where('user_id', $user->id)->exists();

        if ($hasPreference) {
            // PENGGUNA LAMA (Sudah punya kriteria)
            // Sesuai permintaanmu: Langsung ke Halaman Cari Jodoh
            return redirect('/cari-jodoh')->with('success', 'Profil berhasil diupdate!');
        } else {
            // PENGGUNA BARU (Belum punya kriteria)
            // Tetap harus ke atur kriteria dulu, kalau tidak nanti error di halaman cari jodoh
            return redirect('/atur-kriteria')->with('success', 'Profil aman! Sekarang atur kriteria dulu ya.');
        }
    }
}