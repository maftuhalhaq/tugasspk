<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            // Menghubungkan tabel ini dengan tabel users (Relasi One-to-One)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // --- KRITERIA HARAPAN (TARGET) ---
            // User ingin pasangannya seperti apa?
            $table->string('preferred_religion')->nullable(); // Harapan Agama
            $table->string('preferred_domisili')->nullable(); // Harapan Kota
            $table->integer('preferred_age_min')->nullable(); // Minimal Umur
            $table->integer('preferred_age_max')->nullable(); // Maksimal Umur
            $table->integer('preferred_income_level')->nullable(); // Harapan Level Gaji (1-5)
            $table->integer('preferred_education_level')->nullable(); // Harapan Pendidikan (1-5)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
};