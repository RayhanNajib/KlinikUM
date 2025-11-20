<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Menampilkan riwayat janji temu pasien
     */
    public function index()
    {
        $patientId = Auth::user()->patient->id;

        $upcomingAppointments = Appointment::where('patient_id', $patientId)
            ->whereIn('status', ['Menunggu'])
            ->whereHas('schedule', function($q) {
                $q->where('tanggal_praktek', '>=', Carbon::today());
            })
            ->with('schedule.doctor.user')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $pastAppointments = Appointment::where('patient_id', $patientId)
            ->where(function($q) {
                $q->whereIn('status', ['Selesai', 'Batal'])
                  ->orWhereHas('schedule', function($sq) {
                      $sq->where('tanggal_praktek', '<', Carbon::today());
                  });
            })
            ->with('schedule.doctor.user')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('patient.appointment.index', compact('upcomingAppointments', 'pastAppointments'));
    }

    /**
     * Membatalkan janji temu
     */
    public function cancel(Appointment $appointment)
    {
        if ($appointment->patient_id != Auth::user()->patient->id) {
            return redirect()->back()->with('error', 'Aksi tidak diizinkan.');
        }

        if ($appointment->schedule->tanggal_praktek < Carbon::today()) {
            return redirect()->back()->with('error', 'Tidak dapat membatalkan janji yang sudah lewat.');
        }

        $appointment->status = 'Batal';
        $appointment->save();

        $schedule = $appointment->schedule;
        if ($schedule->status == 'Penuh') {
            $schedule->status = 'Tersedia';
            $schedule->save();
        }

        return redirect()->route('pasien.appointment.index')
                         ->with('success', 'Janji temu berhasil dibatalkan.');
    }
}