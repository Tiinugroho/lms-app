<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: X IPA 1
            $table->integer('level'); // Contoh: 10, 11, 12
            // Relasi ke wali kelas (opsional, boleh kosong jika belum ada)
            $table->foreignId('homeroom_teacher_id')->nullable()->constrained('teachers')->nullOnDelete(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};