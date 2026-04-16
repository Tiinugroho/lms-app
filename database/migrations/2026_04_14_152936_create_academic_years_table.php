<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: "2024/2025"
            $table->boolean('is_active')->default(false); // Hanya 1 yang boleh aktif
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('academic_years');
    }
};