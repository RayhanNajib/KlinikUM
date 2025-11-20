@extends('layouts.app')

@section('title', 'Konfirmasi Janji Temu')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Konfirmasi Janji Temu</h1>

<div class="row">
    <div class="col-lg-7">
        <div class="content-card">
            <h5 class="mb-3">Detail Jadwal</h5>
            <table class="table table-borderless">
                <tr>
                    <td style="width: 150px;">Dokter</td>
                    <td>: <strong>{{ $schedule->doctor->user->name }}</strong> ({{ $schedule->doctor->specialties }})</td>
                </tr>
                <tr>
                    <td>Sesi</td>
                    <td>: {{ $schedule->title }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ \Carbon\Carbon::parse($schedule->tanggal_praktek)->format('l, d F Y') }}</td>
                </tr>
                <tr>
                    <td>Waktu</td>
                    <td>: {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }} WIB</td>
                </tr>
            </table>

            <hr class="my-4">

            <h5 class="mb-3">Data Pasien</h5>
            <table class="table table-borderless">
                <tr>
                    <td style="width: 150px;">Nama</td>
                    <td>: <strong>{{ Auth::user()->name }}</strong></td>
                </tr>
                <tr>
                    <td>NIM/NIK</td>
                    <td>: {{ Auth::user()->patient->nim_nik }}</td>
                </tr>
            </table>
            
            <hr class="my-4">
            
            <form action="{{ route('pasien.jadwal.book.store', $schedule->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="keluhan">Tuliskan Keluhan Utama Anda</label>
                    <textarea name="keluhan" id="keluhan" rows="4" class="form-control @error('keluhan') is-invalid @enderror" placeholder="Contoh: Demam tinggi 3 hari, batuk, dan sakit tenggorokan." required>{{ old('keluhan') }}</textarea>
                    @error('keluhan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fa-solid fa-check me-2"></i> Ya, Konfirmasi Pendaftaran
                    </button>
                    <a href="{{ route('pasien.jadwal.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>

        </div>
    </div>
    <div class="col-lg-5">
        <div class="content-card" style="background-color: var(--sidebar-active-bg);">
            <h5><i class="fa-solid fa-circle-info me-2"></i> Perhatian</h5>
            <p>Harap diperhatikan:</p>
            <ul>
                <li>Pastikan Anda datang 15 menit sebelum jadwal.</li>
                <li>Nomor antrean akan diberikan setelah Anda mengkonfirmasi pendaftaran.</li>
                <li>Jika berhalangan hadir, harap segera batalkan janji temu melalui halaman "Riwayat Konsultasi".</li>
            </ul>
        </div>
    </div>
</div>
@endsection