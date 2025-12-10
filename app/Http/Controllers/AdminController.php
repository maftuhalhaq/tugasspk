<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // 1. DASHBOARD & LAPORAN (Sesuai DFD Output: Laporan Statistik)
    public function dashboard()
    {
        // Hitung statistik sederhana
        $totalUsers = User::where('role', 'user')->count();
        $totalPria = User::where('gender', 'L')->count();
        $totalWanita = User::where('gender', 'P')->count();

        return view('admin.dashboard', compact('totalUsers', 'totalPria', 'totalWanita'));
    }

    // 2. KELOLA BOBOT GAP (Sesuai DFD Input: Data Pembobotan Kriteria)
    public function editWeights()
    {
        $weights = DB::table('gap_weights')->orderBy('gap', 'asc')->get();
        return view('admin.weights', compact('weights'));
    }

    public function updateWeights(Request $request)
    {
        // Admin bisa update nilai bobot misal Gap 0 jadi 6
        foreach ($request->weights as $id => $val) {
            DB::table('gap_weights')->where('id', $id)->update(['weight' => $val]);
        }
        return back()->with('success', 'Data Pembobotan berhasil diupdate!');
    }

    // 3. VALIDASI USER (Sesuai DFD Input: Validasi User)
    public function usersList()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.users_list', compact('users'));
    }

    public function deleteUser($id)
    {
        User::destroy($id); // Anggap ini proses validasi (hapus user spam)
        return back()->with('success', 'User dihapus/ditolak.');
    }
}