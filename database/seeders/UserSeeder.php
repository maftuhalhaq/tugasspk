<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun USER UTAMA (Ceritanya ini yang Login)
        // Cowok, Gaji Level 3, S1, Islam, Malang
        $myId = DB::table('users')->insertGetId([
            'name' => 'Budi Pencari Cinta',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'L',
            'religion' => 'Islam',
            'domisili' => 'Malang',
            'income_level' => 3, // Misal: 3-5 Juta
            'education_level' => 3, // Misal: S1
            'date_of_birth' => '2000-01-01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Isi Preferensi si Budi (Budi maunya apa?)
        DB::table('user_preferences')->insert([
            'user_id' => $myId,
            'preferred_religion' => 'Islam',
            'preferred_domisili' => 'Malang',
            'preferred_income_level' => 3, // Harapannya ceweknya gajinya setara
            'preferred_education_level' => 3, // Harapannya ceweknya S1
        ]);

        // 2. Buat KANDIDAT A (Siti - Cocok Banget / Perfect Match)
        // Cewek, Islam, Malang, Gaji 3, S1
        DB::table('users')->insert([
            'name' => 'Siti Soleha',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'P',
            'religion' => 'Islam',
            'domisili' => 'Malang', // COCOK
            'income_level' => 3,    // COCOK (Gap 0)
            'education_level' => 3, // COCOK (Gap 0)
            'date_of_birth' => '2002-05-05',
        ]);

        // 3. Buat KANDIDAT B (Rina - Agak Meleset)
        // Cewek, Islam, Surabaya (Beda Kota), Gaji 1 (Kurang)
        DB::table('users')->insert([
            'name' => 'Rina Rantau',
            'email' => 'rina@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'P',
            'religion' => 'Islam',
            'domisili' => 'Surabaya', // TIDAK COCOK (Beda Kota)
            'income_level' => 1,      // TIDAK COCOK (Gap -2)
            'education_level' => 3,
            'date_of_birth' => '2001-08-17',
        ]);
    }
}