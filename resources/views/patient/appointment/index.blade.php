@extends('layouts.app')

@section('title', 'Riwayat Janji Temu')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Riwayat Janji Temu Saya</h1>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<h5 class="mb-3">Janji Temu Aktif (Menunggu)</h5>
<div class="content-card mb-4">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>No. Antrean</th>
                    <th>Dokter</th>
                    <th>Jadwal</th>
                    <th>Keluhan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($upcomingAppointments as $app)
                <tr>
                    <td>
                        <span class="badge bg-primary fs-6">{{ $app->nomor_antrean }}</span>
                    </td>
                    <td>{{ $app->schedule->doctor->user->name }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($app->schedule->tanggal_praktek)->format('d M Y') }}
                        ({{ \Carbon\Carbon::parse($app->schedule->jam_mulai)->format('H:i') }} WIB)
                    </td>
                    <td>{{ \Illuminate\Support\Str::limit($app->keluhan, 40) }}</td>
                    <td>
                        <form action="{{ route('pasien.appointment.cancel', $app->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan janji temu ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Batalkan</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Anda tidak memiliki janji temu yang aktif.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<h5 class="mb-3">Riwayat Terdahulu</h5>
<div class="content-card">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>Dokter</th>
                    <th>Jadwal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                 @forelse ($pastAppointments as $app)
                <tr>
                    <td>{{ $app->schedule->doctor->user->name }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($app->schedule->tanggal_praktek)->format('d M Y') }}
                    </td>
                    <td>
                        @if($app->status == 'Selesai')
                            <span class="badge bg-success">Selesai</span>
                        @elseif($app->status == 'Batal')
                            <span class="badge bg-secondary">Dibatalkan</span>
                        @else
                            <span class="badge bg-warning text-dark">Lewat Jadwal</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">Belum ada riwayat janji temu.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection