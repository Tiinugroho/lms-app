<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('academic_years', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Mengganti 'name' menjadi period dan semester
            $table->string('period', 9); // Contoh: "2024/2025"
            $table->enum('semester', ['Ganjil', 'Genap']);
            
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->softDeletes();

            // Mencegah ada 2 record "2024/2025 Ganjil"
            $table->unique(['period', 'semester'], 'unique_period_semester');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_years');
    }
};