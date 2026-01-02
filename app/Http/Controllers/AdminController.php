<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Interaction; // Model baru (buat nanti)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    // 1. DASHBOARD UTAMA
    public function dashboard()
    {
        // 1. Statistik Card Utama
        $stats = [
            'total_users'   => User::where('role', 'user')->count(),
            'pending_users' => User::where('role', 'user')->where('status', 'pending')->count(),
            'approved_users'=> User::where('role', 'user')->where('status', 'approved')->count(),
            'total_matches' => DB::table('interactions')->count(),
        ];

        // 2. Data Chart Domisili (Bar Chart)
        $domisiliData = User::where('role', 'user')
            ->select('domisili', DB::raw('count(*) as total'))
            ->groupBy('domisili')
            ->orderByDesc('total') // Urutkan dari terbanyak
            ->take(5) // Ambil top 5 kota saja biar rapi
            ->get();

        // 3. [BARU] Data Chart Umur (Doughnut Chart)
        $users = User::where('role', 'user')->get();
        $ageGroups = [
            '18-24 (Gen Z)'      => 0,
            '25-34 (Millennial)' => 0,
            '35-49 (Gen X)'      => 0,
            '50+ (Senior)'       => 0
        ];

        foreach($users as $u) {
            if ($u->date_of_birth) {
                $age = Carbon::parse($u->date_of_birth)->age;
                if($age <= 24) $ageGroups['18-24 (Gen Z)']++;
                elseif($age <= 34) $ageGroups['25-34 (Millennial)']++;
                elseif($age <= 49) $ageGroups['35-49 (Gen X)']++;
                else $ageGroups['50+ (Senior)']++;
            }
        }

        // 4. Data Pendaftar Terbaru
        $newUsers = User::where('role', 'user')->where('status', 'pending')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'domisiliData', 'ageGroups', 'newUsers'));
    }

    public function users()
    {
        // 1. Ambil Data User
        $users = User::where('role', 'user')
            ->orderByRaw("FIELD(status, 'pending', 'rejected', 'approved')")
            ->latest()
            ->get();

        // 2. LOGIKA INSIGHT (Statistik Mini)
        $totalUsers = $users->count();

        // Rasio Gender (Penting buat Dating App)
        $countL = $users->where('gender', 'L')->count();
        $countP = $users->where('gender', 'P')->count();

        // Menghindari pembagian dengan nol
        $percentL = $totalUsers > 0 ? round(($countL / $totalUsers) * 100) : 0;
        $percentP = $totalUsers > 0 ? round(($countP / $totalUsers) * 100) : 0;

        // Rata-rata Umur
        $totalAge = 0;
        $countDob = 0;
        foreach($users as $u) {
            if($u->date_of_birth) {
                $totalAge += \Carbon\Carbon::parse($u->date_of_birth)->age;
                $countDob++;
            }
        }
        $avgAge = $countDob > 0 ? round($totalAge / $countDob) : 0;

        // Rata-rata Penghasilan
        $avgIncome = $users->avg('income_level');

        return view('admin.users', compact('users', 'totalUsers', 'countL', 'countP', 'percentL', 'percentP', 'avgAge', 'avgIncome'));
    }

    public function approveUser($id)
    {
        User::where('id', $id)->update(['status' => 'approved']);
        return back()->with('success', 'User berhasil disetujui (Approved)!');
    }

    // --- [BARU] FUNGSI TOLAK (Minta Revisi) ---
    public function rejectUser($id)
    {
        User::where('id', $id)->update(['status' => 'rejected']);
        return back()->with('warning', 'User ditolak. Mereka diminta memperbaiki data.');
    }

    // --- [UPDATE] FUNGSI HAPUS (Permanen) ---
    public function deleteUser($id)
    {
        User::destroy($id);
        return back()->with('success', 'User berhasil dihapus permanen.');
    }

    // 3. HALAMAN ATUR BOBOT SPK
    public function weights()
    {
        $gapWeights = DB::table('gap_weights')->orderBy('gap', 'asc')->get();
        $criteriaWeights = DB::table('criteria_weights')->get();

        // LOAD CONFIG JSON
        $jsonPath = storage_path('app/spk_settings.json');

        $defaults = [
            'income_ranges' => [
                ['limit' => 0, 'weight' => 5.0],
                ['limit' => 500000, 'weight' => 4.5],
                ['limit' => 1000000, 'weight' => 4.0],
                ['limit' => 3000000, 'weight' => 3.0],
                ['limit' => 5000000, 'weight' => 2.0],
                ['limit' => 10000000, 'weight' => 1.0],
            ],
            'points' => [
                'rel_match' => 5.0, 'rel_mismatch' => 1.0,
                'loc_match' => 5.0, 'loc_mismatch' => 1.0,
                'bonus_income' => 0.25, 'bonus_edu' => 0.25
            ]
        ];

        $settings = file_exists($jsonPath) ? json_decode(file_get_contents($jsonPath), true) : $defaults;

        // Pastikan key ada biar gak error di view
        $incomeRanges = $settings['income_ranges'] ?? $defaults['income_ranges'];
        $points = array_merge($defaults['points'], $settings['points'] ?? []);

        return view('admin.weights', compact('gapWeights', 'criteriaWeights', 'incomeRanges', 'points'));
    }

    public function updateWeight(Request $request)
    {
       // 1. Update Slider Prioritas (DB)
        if($request->has('criteria')) {
            foreach ($request->criteria as $name => $val) {
                DB::table('criteria_weights')->where('name', $name)->update(['weight' => $val / 100]);
            }
        }

        // 2. Update Bobot GAP Pendidikan (DB)
        if($request->has('gap_weights')) {
            foreach ($request->gap_weights as $id => $val) {
                DB::table('gap_weights')->where('id', $id)->update(['weight' => $val]);
            }
        }

        // 3. Update JSON Settings (Range & Points)
        $currentSettings = [];
        $jsonPath = storage_path('app/spk_settings.json');
        if(file_exists($jsonPath)) $currentSettings = json_decode(file_get_contents($jsonPath), true);

        // A. Simpan Range Penghasilan
        if($request->has('income_range_limits')) {
            $newRanges = [];
            foreach($request->income_range_limits as $key => $limit) {
                $newRanges[] = [
                    'limit' => (int) $limit,
                    'weight' => (float) $request->income_range_weights[$key]
                ];
            }
            usort($newRanges, fn($a, $b) => $a['limit'] <=> $b['limit']);
            $currentSettings['income_ranges'] = $newRanges;
        }

        // B. Simpan Point Config (Agama, Lokasi, Bonus)
        if($request->has('points')) {
            $currentSettings['points'] = [
                'rel_match' => (float) $request->points['rel_match'],
                'rel_mismatch' => (float) $request->points['rel_mismatch'],
                'loc_match' => (float) $request->points['loc_match'],
                'loc_mismatch' => (float) $request->points['loc_mismatch'],
                'bonus_income' => (float) $request->points['bonus_income'],
                'bonus_edu' => (float) $request->points['bonus_edu'],
            ];
        }

        file_put_contents($jsonPath, json_encode($currentSettings));

        return back()->with('success', 'Full Konfigurasi SPK Berhasil Diperbarui!');
    }

    public function resetCriteriaWeights()
    {
        // 1. Reset DB Slider
        $defaultsSlider = ['religion' => 0.25, 'domisili' => 0.25, 'income' => 0.25, 'education' => 0.25];
        foreach ($defaultsSlider as $name => $val) {
            DB::table('criteria_weights')->where('name', $name)->update(['weight' => $val]);
        }

        // 2. Reset DB Gap
        // (Optional: Reset gap_weights table logic here if needed, but usually static is fine)

        // 3. Reset JSON File (Delete it to force default loading)
        $jsonPath = storage_path('app/spk_settings.json');
        if(file_exists($jsonPath)) unlink($jsonPath);

        return back()->with('success', 'Semua konfigurasi berhasil di-reset ke Default Pabrik!');
    }

    // 5. PRINT LAPORAN (Kita update view-nya nanti)
    public function printReport()
    {
        // Ambil data user yang sudah diapprove saja biar laporannya bersih
        $users = User::where('role', 'user')->where('status', 'approved')->get();
        return view('admin.print_users', compact('users'));
    }


}
