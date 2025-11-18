@extends('layouts.app')

@section('title', 'Jadwal Praktek Saya')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Jadwal Praktek Saya</h1>

<div class="content-card">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Sesi</th>
                    <th>Pendaftar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($schedules as $schedule)
                <tr>
                    <td>
                        <strong>{{ \Carbon\Carbon::parse($schedule->tanggal_praktek)->format('d M Y') }}</strong>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}</td>
                    <td>{{ $schedule->title }}</td>
                    <td>
                        <span class="badge bg-info">{{ $schedule->appointments_count }} / {{ $schedule->kuota }}</span>
                    </td>
                    <td>
                        @if($schedule->status == 'Tersedia')
                            <span class="badge bg-success">Tersedia</span>
                        @elseif($schedule->status == 'Penuh')
                            <span class="badge bg-danger">Penuh</span>
                        @else
                            <span class="badge bg-secondary">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Admin belum menambahkan jadwal untuk Anda.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection