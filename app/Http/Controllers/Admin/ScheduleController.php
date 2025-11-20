<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Doctor;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('doctor.user')
                            ->withCount('appointments') 
                            ->orderBy('tanggal_praktek', 'desc')
                            ->get();
        
        return view('admin.jadwal.index', compact('schedules'));
    }


    public function create()
    {
        $doctors = Doctor::with('user')->get();
        return view('admin.jadwal.create', compact('doctors'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'title' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'kuota' => 'required|integer|min:1',
            'skip_weekends' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $createdCount = 0;

        try {
            $tanggalSelesai = $data['tanggal_selesai'] ?? $data['tanggal_mulai'];
            $tanggalMulai = $data['tanggal_mulai'];
            
            /** @var \Carbon\CarbonPeriod $period */ 
            $period = CarbonPeriod::create($tanggalMulai, $tanggalSelesai);


            foreach ($period->toArray() as $date) {
                
                /** @var \Carbon\Carbon $date */
                /** @var \Illuminate\Http\Request $request */
                $skipWeekends = $request->has('skip_weekends');
                if ($skipWeekends && ($date->isSaturday() || $date->isSunday())) {
                    continue; 
                }

                Schedule::create([
                    'doctor_id' => $data['doctor_id'],
                    'title' => $data['title'],
                    'tanggal_praktek' => $date->format('Y-m-d'),
                    'jam_mulai' => $data['jam_mulai'],
                    'jam_selesai' => $data['jam_selesai'],
                    'kuota' => $data['kuota'],
                    'status' => 'Tersedia',
                ]);
                $createdCount++;
            }

            if ($createdCount == 0) {
                 return redirect()->route('admin.jadwal.index')
                         ->with('error', 'Tidak ada jadwal yang dibuat (Mungkin semua tanggal dalam rentang adalah Sabtu/Minggu).');
            }

            return redirect()->route('admin.jadwal.index')
                         ->with('success', "$createdCount jadwal praktek baru berhasil dibuat.");
                         
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal membuat jadwal: '. $e->getMessage());
        }
    }


    public function show(string $id)
    {
        return redirect()->route('admin.jadwal.edit', $id);
    }


    public function edit(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $doctors = Doctor::with('user')->get();
        
        return view('admin.jadwal.edit', compact('schedule', 'doctors'));
    }


    public function update(Request $request, string $id)
    {
        $schedule = Schedule::findOrFail($id);
        
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'title' => 'required|string|max:255',
            'tanggal_praktek' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'kuota' => 'required|integer|min:1',
            'status' => 'required|in:Tersedia,Penuh,Selesai',
        ]);

        if ($request->status == 'Tersedia' && Carbon::parse($request->tanggal_praktek)->isPast() && $schedule->status != 'Tersedia') {
             return back()->withInput()->withErrors(['status' => 'Tidak bisa mengubah status ke "Tersedia" untuk jadwal yang sudah lewat.']);
        }

        $schedule->update($request->all());

        return redirect()->route('admin.jadwal.index')
                         ->with('success', 'Jadwal praktek berhasil diperbarui.');
    }


    public function destroy(string $id)
    {
        try {
            $schedule = Schedule::findOrFail($id);
            
            $waitingPatients = $schedule->appointments()->where('status', 'Menunggu')->count();
            
            if ($waitingPatients > 0) {
                return redirect()->route('admin.jadwal.index')
                                 ->with('error', "Gagal menghapus! Masih ada $waitingPatients pasien yang 'Menunggu' di jadwal ini.");
            }


            $schedule->delete();
            return redirect()->route('admin.jadwal.index')
                             ->with('success', 'Jadwal berhasil dihapus.');
                             
        } catch (\Exception $e) {
            return redirect()->route('admin.jadwal.index')
                             ->with('error', 'Gagal menghapus jadwal.');
        }
    }


    public function destroyAllEmpty()
    {
        try {

            $undeletableCount = Schedule::whereHas('appointments', function($q) {
                $q->where('status', 'Menunggu');
            })->count();


            $schedulesToDelete = Schedule::whereDoesntHave('appointments', function($q) {
                $q->where('status', 'Menunggu');
            })->get(); 
            
            $deletedCount = $schedulesToDelete->count();
            
            if ($deletedCount > 0) {
                foreach ($schedulesToDelete as $schedule) {
                    $schedule->delete();
                }
            }

            if ($deletedCount > 0 && $undeletableCount > 0) {
                return redirect()->route('admin.jadwal.index')
                                 ->with('success', "Berhasil menghapus $deletedCount jadwal. $undeletableCount jadwal tidak dihapus karena masih ada pasien 'Menunggu'.");
            } elseif ($deletedCount > 0 && $undeletableCount == 0) {
                return redirect()->route('admin.jadwal.index')
                                 ->with('success', "Berhasil menghapus semua $deletedCount jadwal yang tidak memiliki antrean aktif.");
            } else {
                return redirect()->route('admin.jadwal.index')
                                 ->with('error', 'Tidak ada jadwal yang bisa dihapus (Semua jadwal masih memiliki antrean aktif).');
            }

        } catch (\Exception $e) {
            return redirect()->route('admin.jadwal.index')
                             ->with('error', 'Gagal menghapus jadwal: ' . $e->getMessage());
        }
    }
}