<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
            $table->integer('nomor_antrean');
            $table->enum('status', ['Menunggu', 'Selesai', 'Batal'])->default('Menunggu');
            $table->text('keluhan')->nullable(); // Opsional
            $table->timestamps();
            
            // Pasien tidak boleh booking jadwal yang sama 2x
            $table->unique(['patient_id', 'schedule_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('appointments');
    }
};