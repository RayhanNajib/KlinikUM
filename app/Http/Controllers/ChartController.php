<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{

    public function getChartData(Request $request)
    {
        $range = $request->input('range', '7days'); 
        $user = Auth::user();

        $endDate = Carbon::today();
        $startDate = match ($range) {
            'today' => Carbon::today(),
            'all' => Appointment::min('created_at') ?? Carbon::today(),
            default => Carbon::today()->subDays(6), 
        };

        $query = Appointment::where('status', 'Selesai') 
                            ->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()]);

        if ($user->role == 'admin') {
        } 
        elseif ($user->role == 'doctor') {
            $doctorId = $user->doctor->id;
            $query->whereHas('schedule', function($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId);
            });
        } 
        elseif ($user->role == 'patient') {
            $patientId = $user->patient->id;
            $query->where('patient_id', $patientId);
        }

        $appointments = $query
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->pluck('count', 'date'); 

        
        $labels = [];
        $data = [];
        $currentDate = $startDate->clone();

        while ($currentDate <= $endDate) {
            $dateString = $currentDate->format('Y-m-d');
            $labels[] = $currentDate->format('d M'); // Format '14 Nov'
            
            $data[] = $appointments[$dateString] ?? 0;
            
            $currentDate->addDay();
        }
        
        if ($range == 'today') {
            $labels = ['Hari Ini'];
            $data = [$appointments[Carbon::today()->format('Y-m-d')] ?? 0];
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }
}