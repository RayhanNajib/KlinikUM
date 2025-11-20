<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $riwayatPasien = Appointment::where('status', 'Selesai') // Hanya ambil yang status selesai
            ->whereHas('schedule', function($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId);
            })
            ->with(['patient.user', 'payment', 'medicalCertificate']) // Load payment & surat
            ->orderBy('updated_at', 'desc')
            ->paginate(10); 

        return view('doctor.appointment.index', compact('antreanHariIni', 'riwayatPasien'));
    }

    /**
     * Fungsi Utama: Dokter menyelesaikan pemeriksaan & input biaya
     */
    public function processAndBill(Request $request, Appointment $appointment)
    {
        $doctorId = Auth::user()->doctor->id;

        if ($appointment->schedule->doctor_id != $doctorId) {
            return back()->with('error', 'Anda tidak memiliki akses ke pasien ini.');
        }

        $request->validate([
            'diagnosa' => 'required|string', 
            'biaya_dokter' => 'required|numeric|min:0',
            'biaya_tindakan' => 'required|numeric|min:0',
            'biaya_obat' => 'required|numeric|min:0',
            'metode_bayar' => 'required|in:Tunai,QRIS',
        ]);

        DB::beginTransaction();
        try {
            $appointment->status = 'Selesai';
            $appointment->save();

            $total = $request->biaya_dokter + $request->biaya_tindakan + $request->biaya_obat;
            

            $statusBayar = ($request->metode_bayar == 'QRIS') ? 'Lunas' : 'Belum Lunas'; 

            Payment::create([
                'appointment_id' => $appointment->id,
                'biaya_dokter' => $request->biaya_dokter,
                'biaya_tindakan' => $request->biaya_tindakan,
                'biaya_obat' => $request->biaya_obat,
                'total_bayar' => $total,
                'metode_bayar' => $request->metode_bayar,
                'status' => $statusBayar, 
            ]);

            DB::commit();
            return redirect()->route('dokter.appointment.index')
                             ->with('success', 'Pemeriksaan selesai & Tagihan berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}