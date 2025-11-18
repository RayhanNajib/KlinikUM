<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Fungsi 'up' ini akan menambahkan kolom 'avatar' 
     * ke tabel 'users' yang sudah ada.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            
            // Menambahkan kolom 'avatar'
            $table->string('avatar')      // Tipe data string (untuk menyimpan nama file)
                  ->nullable()        // Boleh kosong
                  ->default('default.png') // Jika kosong, isi otomatis dgn 'default.png'
                  ->after('password'); // Letakkan kolom ini setelah kolom 'password'
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * Fungsi 'down' ini akan menghapus kolom 'avatar' 
     * jika migrasi di-rollback.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            
            // Hapus kolom 'avatar' jika ada
            $table->dropColumn('avatar');
        
        });
    }
};