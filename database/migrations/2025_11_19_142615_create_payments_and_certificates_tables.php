<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Pembayaran (Kasir)
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');
            // Rincian Biaya
            $table->decimal('biaya_dokter', 10, 2)->default(0);
            $table->decimal('biaya_tindakan', 10, 2)->default(0);
            $table->decimal('biaya_obat', 10, 2)->default(0);
            $table->decimal('total_bayar', 10, 2);
            // Status
            $table->enum('status', ['Belum Lunas', 'Lunas'])->default('Belum Lunas');
            $table->string('metode_bayar')->nullable(); // Tunai, Transfer, dll
            $table->timestamps();
        });

        // 2. Tabel Surat Keterangan Medis (SKM)
        Schema::create('medical_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');
            $table->enum('tipe_surat', ['Sehat', 'Sakit']);
            
            // Data untuk SK Sehat
            $table->string('tinggi_badan')->nullable();
            $table->string('berat_badan')->nullable();
            $table->string('tensi')->nullable();
            $table->string('buta_warna')->nullable(); // Ya/Tidak
            $table->string('golongan_darah')->nullable();
            
            // Data untuk SK Sakit
            $table->integer('jumlah_hari_istirahat')->nullable();
            $table->date('mulai_tanggal')->nullable();
            $table->date('sampai_tanggal')->nullable();
            
            $table->text('catatan_tambahan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_certificates');
        Schema::dropIfExists('payments');
    }
};