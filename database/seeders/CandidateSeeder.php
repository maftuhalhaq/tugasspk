<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CandidateSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');
        $now = now();

        $candidates = [
            // 1. KANDIDAT PERFECT (Saingan Siti)
            [
                'name' => 'Aisyah Perfect',
                'gender' => 'P',
                'religion' => 'Islam',
                'domisili' => 'Malang',
                'income_level' => 4500000, // Gaji 4.5 Juta (Bukan Level 3 lagi)
                'education_level' => 3, // S1 (Pendidikan tetap butuh poin 1-5 utk hitungan)
                'date_of_birth' => '2001-01-01',
            ],
            // 2. KANDIDAT KAYA RAYA (Level 5)
            [
                'name' => 'Jessica Sultan',
                'gender' => 'P',
                'religion' => 'Kristen',
                'domisili' => 'Surabaya',
                'income_level' => 25000000, // Gaji 25 Juta
                'education_level' => 3,
                'date_of_birth' => '1999-05-12',
            ],
            // 3. KANDIDAT INTELEKTUAL (S3)
            [
                'name' => 'Profesor Sarah',
                'gender' => 'P',
                'religion' => 'Islam',
                'domisili' => 'Jakarta',
                'income_level' => 12000000, // Gaji 12 Juta
                'education_level' => 5, // S3
                'date_of_birth' => '1995-08-20',
            ],
            // 4. KANDIDAT SEDERHANA
            [
                'name' => 'Neng Imah',
                'gender' => 'P',
                'religion' => 'Islam',
                'domisili' => 'Malang',
                'income_level' => 1500000, // Gaji UMR Rendah
                'education_level' => 1, // SMA
                'date_of_birth' => '2003-02-14',
            ],
            // 5. KANDIDAT TETANGGA
            [
                'name' => 'Dewi Malang',
                'gender' => 'P',
                'religion' => 'Islam',
                'domisili' => 'Malang',
                'income_level' => 3500000, // Gaji 3.5 Juta
                'education_level' => 2, // D3
                'date_of_birth' => '2002-11-10',
            ],
            // ... Tambahkan data lain sesuai selera, pakai angka jutaan ...
        ];

        foreach ($candidates as $c) {
            DB::table('users')->insert(array_merge($c, [
                'email' => strtolower(str_replace(' ', '', $c['name'])) . '@example.com',
                'password' => $password,
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}