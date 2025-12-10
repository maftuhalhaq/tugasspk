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
        Schema::table('user_preferences', function (Blueprint $table) {
            // 1 = Wajib (Filter), 0 = Opsional (Bobot SPK)
            $table->boolean('strict_religion')->default(true); // Default Agama Wajib
            $table->boolean('strict_domisili')->default(true); // Default Kota Wajib
            $table->boolean('strict_income')->default(false);  // Default Gaji Opsional
            $table->boolean('strict_education')->default(false); // Default Pend Opsional
        });
    }

    public function down(): void
    {
        Schema::table('user_preferences', function (Blueprint $table) {
            $table->dropColumn(['strict_religion', 'strict_domisili', 'strict_income', 'strict_education']);
        });
    }
};