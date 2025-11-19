<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'tipe_surat',
        'tinggi_badan',
        'berat_badan',
        'tensi',
        'buta_warna',
        'golongan_darah',
        'jumlah_hari_istirahat',
        'mulai_tanggal',
        'sampai_tanggal',
        'catatan_tambahan',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}