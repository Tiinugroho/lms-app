<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('classroom_student', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('classroom_id')->constrained('classrooms')->cascadeOnDelete();
            $table->foreignUuid('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignUuid('academic_year_id')->constrained('academic_years')->restrictOnDelete();
            $table->timestamps();
            $table->unique(['student_id', 'academic_year_id']);
            $table->softDeletes(); // Tambahkan soft deletes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classroom_student');
    }
};
