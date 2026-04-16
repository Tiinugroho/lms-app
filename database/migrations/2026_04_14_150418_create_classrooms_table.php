<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->integer('level');
            $table->foreignUuid('homeroom_teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes(); // Tambahkan soft deletes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
