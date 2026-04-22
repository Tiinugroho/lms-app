<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Relasi
            $table->foreignUuid('teacher_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('subject_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('classroom_id')->constrained()->onDelete('cascade');
            
            // Info Tugas
            $table->string('title'); // Contoh: "Tugas Harian 1", "Ulangan Bab 2"
            $table->text('description')->nullable(); // Instruksi soal
            $table->string('file_path')->nullable(); // Jika guru melampirkan soal PDF
            
            // Klasifikasi Penilaian
            $table->enum('type', ['Tugas Harian', 'Kuis Mingguan', 'Ulangan Harian', 'PTS', 'PAS']);
            
            // Tenggat Waktu (Deadline)
            $table->dateTime('due_date');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};