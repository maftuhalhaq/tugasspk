<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GapWeightsSeeder extends Seeder
{
    public function run(): void
    {
        // Aturan sesuai Bab 3 Skripsi biasanya seperti ini:
        $data = [
            ['gap' => 0, 'weight' => 5.0, 'description' => 'Sangat Cocok (Selisih 0)'],
            ['gap' => 1, 'weight' => 4.5, 'description' => 'Kelebihan 1 tingkat'],
            ['gap' => -1, 'weight' => 4.0, 'description' => 'Kekurangan 1 tingkat'],
            ['gap' => 2, 'weight' => 3.5, 'description' => 'Kelebihan 2 tingkat'],
            ['gap' => -2, 'weight' => 3.0, 'description' => 'Kekurangan 2 tingkat'],
            ['gap' => 3, 'weight' => 2.5, 'description' => 'Kelebihan 3 tingkat'],
            ['gap' => -3, 'weight' => 2.0, 'description' => 'Kekurangan 3 tingkat'],
            ['gap' => 4, 'weight' => 1.5, 'description' => 'Kelebihan 4 tingkat'],
            ['gap' => -4, 'weight' => 1.0, 'description' => 'Kekurangan 4 tingkat'],
        ];

        DB::table('gap_weights')->insert($data);
    }
}