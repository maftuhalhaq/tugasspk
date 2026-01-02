<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Menampilkan Halaman Edit Profil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile_edit', compact('user'));
    }

    /**
     * Memproses Simpan Perubahan Profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi Input
        $request->validate([
            'name'            => 'required|string|max:255',
            'date_of_birth'   => 'required|date',
            'gender'          => 'required|in:L,P',
            'domisili'        => 'required|string|max:100',
            'religion'        => 'required|string',
            'education_level' => 'required|integer|in:1,2,3,4,5',
            'real_income'     => 'required|numeric|min:0', // Di form name-nya 'real_income'

            // Validasi Kontak & Foto
            'whatsapp'        => 'required|numeric',       // Wajib angka
            'instagram'       => 'nullable|string|max:50', // Opsional
            'photo'           => 'nullable|image|mimes:jpeg,png,jpg,gif', // Max 2MB
        ]);

        // 2. Update Data Text ke Object User
        $user->name            = $request->name;
        $user->date_of_birth   = $request->date_of_birth;
        $user->gender          = $request->gender;
        $user->domisili        = $request->domisili;
        $user->religion        = $request->religion;
        $user->education_level = $request->education_level;
        $user->income_level    = $request->real_income; // Map ke kolom database income_level
        $user->whatsapp        = $request->whatsapp;
        $user->instagram       = $request->instagram;

        // 3. Logika Upload Foto
        if ($request->hasFile('photo')) {
            // Hapus foto lama dari storage jika ada (biar server gak penuh sampah)
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Simpan foto baru ke folder 'public/profile-photos'
            // Hasilnya path seperti: profile-photos/namafileacak.jpg
            $path = $request->file('photo')->store('profile-photos', 'public');

            // Simpan path ke database
            $user->profile_photo_path = $path;
        }

        // Jika user ditolak admin, lalu dia update profil, ubah jadi pending lagi
        if ($user->status === 'rejected') {
            $user->status = 'pending';
        }

        // 4. Simpan Perubahan ke Database
        $user->save();

        // Jika user masih 'pending' (baru daftar), lempar ke Ruang Tunggu
        if ($user->status === 'pending') {
            return redirect()->route('waiting');
        }

        // Jika user sudah 'approved' (user lama), biarkan tetap di halaman edit
        return back()->with('success', 'Profil berhasil diperbarui! Foto makin kece 😎');
    }
}
