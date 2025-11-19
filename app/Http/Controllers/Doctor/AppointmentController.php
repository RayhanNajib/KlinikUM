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

        // Pasien yang MENUNGGU hari ini
        $antreanHariIni = Appointment::where('status', 'Menunggu')
            ->whereHas('schedule', function($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId)
                  ->where('tanggal_praktek', Carbon::today());
            })
            ->with('patient.user') 
            ->orderBy('nomor_antrean', 'asc') 
            ->get();

        // Riwayat Pasien (Selesai)
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

        // Validasi: Pastikan pasien ini milik dokter yang login
        if ($appointment->schedule->doctor_id != $doctorId) {
            return back()->with('error', 'Anda tidak memiliki akses ke pasien ini.');
        }

        $request->validate([
            'diagnosa' => 'required|string', // Kita simpan ini di kolom 'keluhan' atau buat kolom baru nanti
            'biaya_dokter' => 'required|numeric|min:0',
            'biaya_tindakan' => 'required|numeric|min:0',
            'biaya_obat' => 'required|numeric|min:0',
            'metode_bayar' => 'required|in:Tunai,QRIS',
        ]);

        DB::beginTransaction();
        try {
            // 1. Update Status Appointment & Catatan Dokter
            $appointment->status = 'Selesai';
            // Catatan: Idealnya ada kolom 'diagnosa', tapi sementara kita gabung ke 'keluhan' atau biarkan keluhan pasien.
            // Jika ingin menimpa keluhan dengan diagnosa: $appointment->keluhan = "Keluhan: " . $appointment->keluhan . " | Diagnosa: " . $request->diagnosa;
            $appointment->save();

            // 2. Hitung Total
            $total = $request->biaya_dokter + $request->biaya_tindakan + $request->biaya_obat;
            
            // Logika Status Bayar:
            // Jika QRIS -> Asumsi Pasien bayar di awal/saat itu juga via HP -> Lunas
            // Jika Tunai -> Harus ke Admin/Kasir -> Belum Lunas (Nanti Admin yang ubah status Lunas saat terima uang)
            // TAPI, sesuai request Anda: "Admin cuman mantau". 
            // Maka Dokter punya kuasa menentukan apakah uang sudah diterima (misal bayar di ruangan dokter).
            // Mari kita buat default 'Lunas' jika dokter sudah input, KECUALI dokternya ingin pasien bayar di depan.
            
            $statusBayar = ($request->metode_bayar == 'QRIS') ? 'Lunas' : 'Belum Lunas'; 
            // Jika Tunai, nanti Pasien bawa invoice ke Admin/Kasir untuk pelunasan.

            // 3. Buat Tagihan (Payment)
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