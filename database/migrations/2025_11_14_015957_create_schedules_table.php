<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->string('title'); // Judul Sesi (Misal: Konsultasi Umum Sesi Pagi)
            $table->date('tanggal_praktek');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('kuota');
            $table->enum('status', ['Tersedia', 'Penuh', 'Selesai'])->default('Tersedia');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('schedules');
    }
};