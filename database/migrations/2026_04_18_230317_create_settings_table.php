<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id(); // Pakai ID biasa saja karena hanya 1 baris
            
            // --- Identitas Website ---
            $table->string('app_name')->default('ERP Sekolah Kita');
            $table->string('app_short_name')->default('ERP'); // Untuk di sidebar yang di-collapse
            
            // --- Media & Branding ---
            $table->string('app_logo')->nullable(); // Path file logo utama
            $table->string('favicon')->nullable(); // Path file icon kecil di tab browser
            
            // --- SEO (Search Engine Optimization) ---
            $table->string('meta_title')->nullable(); // Contoh: "Sistem Informasi Akademik SMAN 1"
            $table->text('meta_description')->nullable(); // Deskripsi untuk Google Search
            $table->string('meta_keywords')->nullable(); // Keyword dipisah koma (opsional)
            
            // --- Kontak & Alamat Sekolah ---
            $table->string('school_phone', 20)->nullable();
            $table->string('school_email')->nullable();
            $table->text('school_address')->nullable();
            
            // --- Link Sosial Media (Opsional, sangat bagus jika ada) ---
            $table->string('instagram_link')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->boolean('is_promotion_open')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};