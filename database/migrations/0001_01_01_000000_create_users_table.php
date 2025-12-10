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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // --- TAMBAHAN KHUSUS SPK (DATA FAKTA) ---
            // Kita tambahkan kolom profil kandidat di sini
            $table->date('date_of_birth')->nullable(); // Tanggal lahir (untuk hitung umur)
            $table->enum('gender', ['L', 'P'])->nullable(); // Pria/Wanita
            $table->string('religion')->nullable(); // Agama
            $table->string('domisili')->nullable(); // Kota tinggal
            $table->integer('income_level')->default(0); // Level Gaji (1-5)
            $table->integer('education_level')->default(0); // Level Pendidikan (1-5)
            // ----------------------------------------

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};