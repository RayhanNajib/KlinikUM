@extends('layouts.app')

@section('title', 'Cari Jadwal Dokter')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Jadwal Praktek Dokter Tersedia</h1>

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<div class="row">
    @forelse ($schedules as $schedule)
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="content-card h-100 d-flex flex-column">
                <div>
                    <span class="badge 
                        @if(\Carbon\Carbon::parse($schedule->tanggal_praktek)->isToday()) 
                            bg-success 
                        @else 
                            bg-primary 
                        @endif 
                        mb-2">
                        {{ \Carbon\Carbon::parse($schedule->tanggal_praktek)->isToday() ? 'HARI INI' : \Carbon\Carbon::parse($schedule->tanggal_praktek)->format('d M Y') }}
                    </span>
                    <h5 class="mb-1" style="color: var(--primary-navy);">{{ $schedule->title }}</h5>
                    <h6 class="mb-2 font-weight-bold" style="color: var(--primary-blue);">
                        {{ $schedule->doctor->user->name }}
                    </h6>
                    <p class="text-muted mb-3">{{ $schedule->doctor->specialties }}</p>
                </div>

                <div class="row border-top border-bottom py-3 my-3">
                    <div class="col-6 text-center border-end">
                        <div class="text-xs text-uppercase text-muted">Jam Praktek</div>
                        <div class="h5 mb-0 font-weight-bold">
                            {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}
                        </div>
                    </div>
                    <div class="col-6 text-center">
                        <div class="text-xs text-uppercase text-muted">Sisa Kuota</div>
                        <div class="h5 mb-0 font-weight-bold">
                            {{ $schedule->kuota - $schedule->appointments->count() }}
                        </div>
                    </div>
                </div>

                <div class="mt-auto">
                    <a href="{{ route('pasien.jadwal.book.show', $schedule->id) }}" class="btn btn-primary w-100">
                        <i class="fa-solid fa-calendar-check me-2"></i> Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="content-card text-center">
                <p>Belum ada jadwal dokter yang tersedia saat ini.</p>
            </div>
        </div>
    @endforelse
</div>
@endsection