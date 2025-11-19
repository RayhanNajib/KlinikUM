<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\MedicalCertificate;

class CertificateController extends Controller
{
    // Form pilih jenis surat
    public function create(Appointment $appointment)
    {
        return view('doctor.certificate.create', compact('appointment'));
    }

    // Simpan data surat
    public function store(Request $request, Appointment $appointment)
    {
        $request->validate([
            'tipe_surat' => 'required|in:Sehat,Sakit',
        ]);

        // Validasi dinamis berdasarkan tipe surat
        if ($request->tipe_surat == 'Sehat') {
            $request->validate([
                'tinggi_badan' => 'required',
                'berat_badan' => 'required',
                'tensi' => 'required',
                'buta_warna' => 'required',
            ]);
        } else {
            $request->validate([
                'jumlah_hari_istirahat' => 'required|integer',
                'mulai_tanggal' => 'required|date',
                'sampai_tanggal' => 'required|date',
            ]);
        }

        MedicalCertificate::create([
            'appointment_id' => $appointment->id,
            'tipe_surat' => $request->tipe_surat,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'tensi' => $request->tensi,
            'buta_warna' => $request->buta_warna,
            'golongan_darah' => $request->golongan_darah,
            'jumlah_hari_istirahat' => $request->jumlah_hari_istirahat,
            'mulai_tanggal' => $request->mulai_tanggal,
            'sampai_tanggal' => $request->sampai_tanggal,
            'catatan_tambahan' => $request->catatan_tambahan,
        ]);

        return redirect()->route('dokter.appointment.index')->with('success', 'Surat Keterangan Medis berhasil dibuat.');
    }

    // Cetak Surat
    public function print(MedicalCertificate $certificate)
    {
        return view('doctor.certificate.print', compact('certificate'));
    }
}