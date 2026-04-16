<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nis', 20)->unique();
            $table->string('nisn', 20)->unique()->nullable();
            $table->enum('gender', ['L', 'P']);
            $table->string('phone_number', 15)->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Tambahkan soft deletes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
