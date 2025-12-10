<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // 1. Tambah kolom di tabel USERS (Untuk Foto & Kontak)
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_photo_path', 2048)->nullable()->after('name'); // Foto Profil
            $table->string('whatsapp')->nullable()->after('domisili'); // WA (Wajib diisi nanti)
            $table->string('instagram')->nullable()->after('whatsapp'); // IG (Opsional)
        });

        // 2. Tambah kolom di tabel USER_PREFERENCES (Untuk Filter Umur)
        Schema::table('user_preferences', function (Blueprint $table) {
            $table->integer('min_age')->default(18)->after('preferred_domisili'); // Minimal Umur
            $table->integer('max_age')->default(50)->after('min_age'); // Maksimal Umur
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['profile_photo_path', 'whatsapp', 'instagram']);
        });

        Schema::table('user_preferences', function (Blueprint $table) {
            $table->dropColumn(['min_age', 'max_age']);
        });
    }
};