<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Appointment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            
            $totalDoctors = User::where('role', 'doctor')->count();
            $totalPatients = User::where('role', 'patient')->count();
            
            $appointmentsToday = Appointment::whereHas('schedule', function($q) {
                $q->where('tanggal_praktek', Carbon::today());
            })->count();
            
            $schedulesAvailable = Schedule::where('status', 'Tersedia')
                                          ->where('tanggal_praktek', '>=', Carbon::today())
                                          ->count();

            return view('dashboard.admin', compact(
                'totalDoctors', 
                'totalPatients', 
                'appointmentsToday', 
                'schedulesAvailable'
            ));
        } 
        elseif ($user->role == 'doctor') {
            
            $doctorId = $user->doctor->id;

            $appointmentsToday = Appointment::where('status', 'Menunggu')
                ->whereHas('schedule', function($q) use ($doctorId) {
                    $q->where('doctor_id', $doctorId)
                      ->where('tanggal_praktek', Carbon::today());
                })->count();

            $schedulesAvailable = Schedule::where('doctor_id', $doctorId)
                ->where('tanggal_praktek', '>=', Carbon::today())
                ->count();

            $totalPasienSaya = Appointment::whereHas('schedule', function($q) use ($doctorId) {
                    $q->where('doctor_id', $doctorId);
                })
                ->distinct('patient_id')
                ->count('patient_id');
            
            return view('dashboard.doctor', compact(
                'appointmentsToday', 
                'schedulesAvailable', 
                'totalPasienSaya'
            ));
        } 
        else {
            $patientId = $user->patient->id;
            $janjiTemuAktif = Appointment::where('patient_id', $patientId)
                                         ->where('status', 'Menunggu')
                                         ->count();
            $totalKonsultasi = Appointment::where('patient_id', $patientId)
                                          ->where('status', 'Selesai')
                                          ->count();

            // REVISI: Data chart dihapus dari sini
            return view('dashboard.patient', compact('janjiTemuAktif', 'totalKonsultasi'));
        }
    }
}