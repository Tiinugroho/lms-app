<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->foreignUuid('attendance_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('student_id')->constrained()->onDelete('cascade');
            
            // Status kehadiran
            $table->enum('status', ['Hadir', 'Sakit', 'Izin', 'Alpa'])->default('Hadir');
            $table->string('notes')->nullable(); // Keterangan tambahan (misal: "Sakit demam berdarah")
            
            $table->timestamps();

            // Satu siswa hanya punya 1 status per 1 jurnal kehadiran
            $table->unique(['attendance_id', 'student_id'], 'unique_attendance_student');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_details');
    }
};