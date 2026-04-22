<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->foreignUuid('teacher_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('subject_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('classroom_id')->constrained()->onDelete('cascade');
            
            $table->string('title'); // Judul materi, misal: "Bab 1: Persamaan Linier"
            $table->text('description')->nullable(); // Penjelasan singkat
            $table->string('file_path')->nullable(); // Untuk upload PDF, Word, PPT
            $table->string('external_link')->nullable(); // Untuk link YouTube, Google Drive luar, dll
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};