<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('criteria_weights', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nama di coding (misal: religion)
            $table->string('label'); // nama tampilan (misal: Agama)
            $table->float('weight')->default(0); // bobot persentase (0.1 - 1.0)
            $table->string('class_icon')->nullable(); // untuk pemanis UI
            $table->string('class_color')->nullable(); // untuk pemanis UI
            $table->timestamps();
        });

        // Insert Data Default (Total harus 1.0 atau 100%)
        DB::table('criteria_weights')->insert([
            ['name' => 'religion', 'label' => 'Agama (Keyakinan)', 'weight' => 0.40, 'class_icon' => 'fa-hands-praying', 'class_color' => 'bg-purple-100 text-purple-600'],
            ['name' => 'domisili', 'label' => 'Domisili (Lokasi)', 'weight' => 0.20, 'class_icon' => 'fa-map-location-dot', 'class_color' => 'bg-rose-100 text-rose-600'],
            ['name' => 'income', 'label' => 'Penghasilan', 'weight' => 0.30, 'class_icon' => 'fa-money-bill-wave', 'class_color' => 'bg-green-100 text-green-600'],
            ['name' => 'education', 'label' => 'Pendidikan', 'weight' => 0.10, 'class_icon' => 'fa-graduation-cap', 'class_color' => 'bg-blue-100 text-blue-600'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criteria_weights');
    }
};
