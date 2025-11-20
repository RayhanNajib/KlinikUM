<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model {
    use HasFactory;
    protected $guarded = ['id'];
    
    public function patient() {
        return $this->belongsTo(Patient::class);
    }
    public function schedule() {
        return $this->belongsTo(Schedule::class);
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function medicalCertificate()
    {
        return $this->hasOne(MedicalCertificate::class);
    }
}