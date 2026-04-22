<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // 4 Pilar Relasi (Super Pivot)
            $table->foreignUuid('academic_year_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('classroom_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('subject_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('teacher_id')->constrained()->onDelete('cascade');

            // Atribut Waktu
            $table->string('day_of_week', 20); // Senin, Selasa, Rabu, dll
            $table->time('start_time');
            $table->time('end_time');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};