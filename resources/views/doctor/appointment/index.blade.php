@extends('layouts.app')

@section('title', 'Pasien Saya')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Antrean Pasien (Hari Ini)</h1>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="content-card mb-4">
    <h5 class="mb-3" style="color: var(--primary-color);">Menunggu Konsultasi</h5>
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>Antrean</th>
                    <th>Nama Pasien</th>
                    <th>NIM/NIK</th>
                    <th>Keluhan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($antreanHariIni as $app)
                <tr>
                    <td>
                        <span class="badge bg-primary fs-6">{{ $app->nomor_antrean }}</span>
                    </td>
                    <td><strong>{{ $app->patient->user->name }}</strong></td>
                    <td>{{ $app->patient->nim_nik }}</td>
                    <td>{{ $app->keluhan }}</td>
                    <td>
                        <form action="{{ route('dokter.appointment.complete', $app->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyelesaikan sesi dengan pasien ini?');">
                            @csrf
                            @method('PATCH')
                            <button typeG="submit" class="btn btn-sm btn-success">
                                <i class="fas fa-check me-1"></i> Selesaikan
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada antrean pasien untuk hari ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<h5 class="mb-3">Riwayat Pasien Terdahulu</h5>
<div class="content-card">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Pasien</th>
                    <th>Keluhan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                 @forelse ($riwayatPasien as $app)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($app->schedule->tanggal_praktek)->format('d M Y') }}</td>
                    <td>{{ $app->patient->user->name }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($app->keluhan, 50) }}</td>
                    <td>
                        @if($app->status == 'Selesai')
                            <span class="badge bg-success">Selesai</span>
                        @else
                            <span class="badge bg-secondary">Dibatalkan</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada riwayat pasien.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $riwayatPasien->links() }}
    </div>
</div>
@endsection