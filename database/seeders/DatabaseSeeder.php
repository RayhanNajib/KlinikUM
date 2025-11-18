<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        User::create([
            'name' => 'Admin Klinik',
            'email' => 'admin@klinikum.id',
            'password' => Hash::make('12345678'), // Password: 12345678
            'role' => 'admin',
            'no_hp' => '08123456789'
        ]);

        // 2. Buat Akun DOKTER
        $dokterUser = User::create([
            'name' => 'Dr. Budi Santoso',
            'email' => 'dokter@klinikum.id',
            'password' => Hash::make('12345678'),
            'role' => 'doctor',
            'no_hp' => '08129876543'
        ]);
        
        // Isi data spesifik dokter
        Doctor::create([
            'user_id' => $dokterUser->id,
            'specialties' => 'Dokter Umum',
            'nip' => '198001012005011001'
        ]);

        // 3. Buat Akun PASIEN (Mahasiswa)
        $pasienUser = User::create([
            'name' => 'Putri Lestari (Mahasiswa)',
            'email' => 'mahasiswa@um.ac.id',
            'password' => Hash::make('12345678'),
            'role' => 'patient',
            'no_hp' => '08567891234'
        ]);

        // Isi data spesifik pasien
        Patient::create([
            'user_id' => $pasienUser->id,
            'nim_nik' => '220533601234',
            'alamat' => 'Jl. Surabaya No. 6, Malang',
            'tgl_lahir' => '2003-05-20',
            'jenis_kelamin' => 'P'
        ]);
    }
}