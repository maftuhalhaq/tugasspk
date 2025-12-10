<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        // 1. Tambah Status di User
    Schema::table('users', function (Blueprint $table) {
        // status: pending, approved, rejected
        $table->string('status')->default('pending')->after('role'); 
    });

    // 2. Tabel Interaksi (Untuk Statistik Admin)
    Schema::create('interactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Yang nge-like
        $table->foreignId('target_id')->constrained('users')->onDelete('cascade'); // Yang di-like
        $table->float('spk_score')->nullable(); // Skor saat itu
        $table->string('action_type')->default('whatsapp'); // whatsapp / view_detail
        $table->timestamps();
    });
    
    // 3. Pastikan tabel bobot ada (Gap Weights)
    if (!Schema::hasTable('gap_weights')) {
        Schema::create('gap_weights', function (Blueprint $table) {
            $table->id();
            $table->integer('gap'); // Selisih (0, 1, -1, dst)
            $table->float('weight'); // Bobot (5, 4.5, dst)
            $table->string('description')->nullable();
            $table->timestamps();
        });
        
        // Seed data awal
        DB::table('gap_weights')->insert([
            ['gap' => 0, 'weight' => 5.0, 'description' => 'Tidak ada selisih (Kompetensi sesuai)'],
            ['gap' => 1, 'weight' => 4.5, 'description' => 'Kelebihan 1 tingkat'],
            ['gap' => -1, 'weight' => 4.0, 'description' => 'Kekurangan 1 tingkat'],
            ['gap' => 2, 'weight' => 3.5, 'description' => 'Kelebihan 2 tingkat'],
            ['gap' => -2, 'weight' => 3.0, 'description' => 'Kekurangan 2 tingkat'],
            ['gap' => 3, 'weight' => 2.5, 'description' => 'Kelebihan 3 tingkat'],
            ['gap' => -3, 'weight' => 2.0, 'description' => 'Kekurangan 3 tingkat'],
            ['gap' => 4, 'weight' => 1.5, 'description' => 'Kelebihan 4 tingkat'],
            ['gap' => -4, 'weight' => 1.0, 'description' => 'Kekurangan 4 tingkat'],
        ]);
    }
    }
};