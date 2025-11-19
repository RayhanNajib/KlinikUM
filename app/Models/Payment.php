<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'appointment_id', // <-- Ini yang Anda minta
        'biaya_dokter',
        'biaya_tindakan',
        'biaya_obat',
        'total_bayar',
        'status',
        'metode_bayar',
    ];

    /**
     * Relasi ke Appointment
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}