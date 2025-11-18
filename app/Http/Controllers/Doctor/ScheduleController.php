<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;

class ScheduleController extends Controller
{

    public function index()
    {
        $doctorId = Auth::user()->doctor->id;

        $schedules = Schedule::where('doctor_id', $doctorId)
            ->withCount('appointments')
            ->orderBy('tanggal_praktek', 'desc')
            ->get();
            
        return view('doctor.jadwal.index', compact('schedules'));
    }
}