<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel users (On Delete Cascade = Jika user dihapus, data dokter ikut terhapus)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Data Spesifik Dokter
            $table->string('specialties')->nullable(); // Spesialisasi (Umum, Gigi, dll)
            $table->string('nip')->nullable(); // Nomor Induk Pegawai (Untuk Dokter Kampus)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
