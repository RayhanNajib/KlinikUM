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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Data Spesifik Pasien (Mahasiswa/Staff)
            $table->string('nim_nik')->unique(); // NIM (Mahasiswa) atau NIK (Umum/Staff)
            $table->date('tgl_lahir')->nullable(); // Tanggal Lahir
            $table->text('alamat')->nullable(); // Alamat di Malang
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable(); // Laki-laki / Perempuan

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
