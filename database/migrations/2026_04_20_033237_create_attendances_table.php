<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Relasi ke jadwal (menyimpan info kelas, mapel, guru, dan tahun ajaran)
            $table->foreignUuid('schedule_id')->constrained()->onDelete('cascade');
            
            $table->date('date'); // Tanggal absensi dilakukan
            $table->integer('meeting_number'); // Pertemuan ke-berapa (1, 2, 3, dst)
            $table->string('topic'); // Topik atau materi yang diajarkan hari itu
            
            $table->timestamps();

            // Opsional: Mencegah guru membuat 2 jurnal untuk pertemuan yang sama di jadwal yang sama
            $table->unique(['schedule_id', 'meeting_number'], 'unique_schedule_meeting');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};