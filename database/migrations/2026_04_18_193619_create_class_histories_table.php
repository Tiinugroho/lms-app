<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('class_histories', function (Blueprint $table) {
            // Jika ingin pakai UUID untuk history juga:
            $table->uuid('id')->primary(); 
            // Jika ingin tetap pakai ID angka biasa, gunakan: $table->id();

            // PENTING: Gunakan foreignUuid karena tabel master Anda memakai UUID
            $table->foreignUuid('student_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('classroom_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('academic_year_id')->constrained()->onDelete('cascade');

            // Status siswa di kelas tersebut (Aktif, Lulus, Pindah, dll)
            $table->string('status')->default('Aktif');

            $table->timestamps();

            // Proteksi: Satu siswa hanya boleh punya satu record per tahun akademik
            // (Karena ID tahun akademik sudah mewakili "Tahun + Semester")
            $table->unique(['student_id', 'academic_year_id'], 'student_academic_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_histories');
    }
};