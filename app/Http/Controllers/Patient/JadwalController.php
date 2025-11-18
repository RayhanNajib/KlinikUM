<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JadwalController extends Controller
{
    /**
     * Menampilkan semua jadwal yang tersedia (belum lewat tanggal & kuota ada)
     */
    public function index()
    {
        // Ambil jadwal yang akan datang dan statusnya 'Tersedia'
        $schedules = Schedule::where('tanggal_praktek', '>=', Carbon::today())
            ->where('status', 'Tersedia')
            ->with('doctor.user') // Eager load relasi dokter
            ->orderBy('tanggal_praktek', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();
            
        return view('patient.jadwal.index', compact('schedules'));
    }

    /**
     * Menampilkan halaman konfirmasi booking
     */
    public function showBookingForm(Schedule $schedule)
    {
        // Cek dulu apakah pasien sudah pernah daftar di jadwal ini
        $patientId = Auth::user()->patient->id;
        $existingAppointment = Appointment::where('patient_id', $patientId)
                                          ->where('schedule_id', $schedule->id)
                                          ->first();

        if ($existingAppointment) {
            return redirect()->route('pasien.appointment.index')
                             ->with('error', 'Anda sudah terdaftar pada jadwal ini.');
        }

        // Cek kuota
        $kuotaTerisi = $schedule->appointments()->count();
        if ($kuotaTerisi >= $schedule->kuota) {
            return redirect()->route('pasien.jadwal.index')
                             ->with('error', 'Maaf, kuota untuk jadwal ini sudah penuh.');
        }

        return view('patient.jadwal.book', compact('schedule'));
    }

    /**
     * Menyimpan data booking
     */
    public function storeBooking(Request $request, Schedule $schedule)
    {
        $request->validate([
            'keluhan' => 'required|string|min:5',
        ]);

        $patient = Auth::user()->patient;

        // Gunakan Transaksi Database untuk mencegah "Race Condition" (rebutan kuota)
        try {
            DB::beginTransaction();

            // Kunci jadwal yang mau di-book agar tidak ada yang bisa memproses jadwal ini bersamaan
            $schedule = Schedule::where('id', $schedule->id)->lockForUpdate()->first();

            // Cek Ulang Kuota (setelah di-lock)
            $kuotaTerisi = $schedule->appointments()->count();
            if ($kuotaTerisi >= $schedule->kuota) {
                DB::rollBack();
                return redirect()->route('pasien.jadwal.index')
                                 ->with('error', 'Maaf, kuota sudah penuh saat Anda konfirmasi.');
            }

            // Cek Ulang Existing Booking
            $existing = Appointment::where('patient_id', $patient->id)
                                   ->where('schedule_id', $schedule->id)
                                   ->exists();
            if ($existing) {
                DB::rollBack();
                return redirect()->route('pasien.appointment.index')
                                 ->with('error', 'Anda sudah terdaftar di jadwal ini.');
            }
            
            // Ambil nomor antrean
            $nomorAntrean = $kuotaTerisi + 1;

            // Buat Janji Temu
            Appointment::create([
                'patient_id' => $patient->id,
                'schedule_id' => $schedule->id,
                'nomor_antrean' => $nomorAntrean,
                'keluhan' => $request->keluhan,
                'status' => 'Menunggu',
            ]);

            // Update status jadwal jika kuota penuh
            if ($nomorAntrean == $schedule->kuota) {
                $schedule->status = 'Penuh';
                $schedule->save();
            }

            DB::commit();

            return redirect()->route('pasien.appointment.index')
                             ->with('success', 'Pendaftaran janji temu berhasil! Nomor antrean Anda: ' . $nomorAntrean);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pasien.jadwal.index')
                             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}