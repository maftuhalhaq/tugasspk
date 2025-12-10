<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Interaction; // Model baru (buat nanti)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // 1. DASHBOARD UTAMA
    public function dashboard()
    {
        // Statistik Card
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'pending_users' => User::where('role', 'user')->where('status', 'pending')->count(),
            'approved_users' => User::where('role', 'user')->where('status', 'approved')->count(),
            'total_matches' => DB::table('interactions')->count(), // Data dari tombol "Ajak Kenalan"
        ];

        // Data Chart (Sebaran Domisili)
        $domisiliData = User::where('role', 'user')
            ->select('domisili', DB::raw('count(*) as total'))
            ->groupBy('domisili')
            ->get();

        // Data Terbaru (Pending)
        $newUsers = User::where('role', 'user')->where('status', 'pending')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'domisiliData', 'newUsers'));
    }

    public function users()
    {
        // Urutkan: Pending paling atas, lalu Rejected, lalu Approved
        $users = User::where('role', 'user')
            ->orderByRaw("FIELD(status, 'pending', 'rejected', 'approved')")
            ->latest()
            ->get();
            
        return view('admin.users', compact('users'));
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
        $weights = DB::table('gap_weights')->orderBy('gap', 'asc')->get();
        return view('admin.weights', compact('weights'));
    }

    public function updateWeight(Request $request)
    {
        // Logic update massal sederhana
        foreach ($request->weights as $id => $val) {
            DB::table('gap_weights')->where('id', $id)->update(['weight' => $val]);
        }
        return back()->with('success', 'Bobot berhasil diperbarui!');
    }
    
    // 4. PRINT LAPORAN (Sederhana view print)
    public function printReport()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.print_users', compact('users'));
    }
}