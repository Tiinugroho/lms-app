<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Relasi ke tabel users
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            
            // Profil Identitas Staff / Tendik
            $table->string('nip', 50)->nullable()->unique(); // Nomor Induk Pegawai (jika PNS/Tetap)
            $table->string('nik', 20)->unique()->nullable(); // Nomor Induk Kependudukan

            $table->string('position'); // Jabatan: misal "Kepala Tata Usaha", "Pustakawan", "Admin Keuangan"
            $table->enum('gender', ['L', 'P']);
            $table->string('phone_number', 20)->nullable();
            $table->text('address')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staffs');
    }
};