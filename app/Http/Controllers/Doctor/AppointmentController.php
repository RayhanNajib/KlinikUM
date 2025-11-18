<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{

    public function index()
    {
        $doctorId = Auth::user()->doctor->id;


        $antreanHariIni = Appointment::where('status', 'Menunggu')
            ->whereHas('schedule', function($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId)
                  ->where('tanggal_praktek', Carbon::today());
            })
            ->with('patient.user') 
            ->orderBy('nomor_antrean', 'asc') 
            ->get();

    
        $riwayatPasien = Appointment::where('status', '!=', 'Menunggu')
            ->whereHas('schedule', function($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId);
            })
            ->with('patient.user')
            ->orderBy('created_at', 'desc')
            ->paginate(10); 

        return view('doctor.appointment.index', compact('antreanHariIni', 'riwayatPasien'));
    }


    public function complete(Appointment $appointment)
    {
    
        $doctorId = Auth::user()->doctor->id;
        if ($appointment->schedule->doctor_id != $doctorId) {
            return redirect()->back()->with('error', 'Aksi tidak diizinkan.');
        }

      
        $appointment->status = 'Selesai';
        $appointment->save();

        return redirect()->route('dokter.appointment.index')
                         ->with('success', 'Konsultasi dengan pasien berhasil diselesaikan.');
    }
}