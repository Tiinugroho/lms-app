<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->foreignUuid('assignment_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('student_id')->constrained()->onDelete('cascade');
            
            // Data dari Siswa
            $table->string('file_path')->nullable(); // File jawaban siswa (PDF/Foto)
            $table->text('student_note')->nullable(); // Catatan dari siswa saat mengumpulkan
            $table->timestamp('submitted_at')->nullable(); // Kapan dikumpulkan (untuk cek telat/tidak)
            
            // Data dari Guru (Penilaian)
            $table->decimal('score', 5, 2)->nullable(); // Nilai (0 - 100)
            $table->text('teacher_feedback')->nullable(); // Komentar/Evaluasi dari guru
            
            $table->timestamps();

            // Satu siswa hanya bisa memiliki 1 baris pengumpulan per tugas
            $table->unique(['assignment_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
    }
};