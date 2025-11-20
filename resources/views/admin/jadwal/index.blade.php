@extends('layouts.app')

@section('title', 'Manajemen Jadwal Praktek')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0" style="color: var(--primary-color);">Manajemen Jadwal Praktek</h1>
    
    <div class="d-flex gap-2">
        <form action="{{ route('admin.jadwal.destroyAllEmpty') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SEMUA jadwal yang KOSONG (belum ada pendaftar)? Jadwal yang sudah ada pendaftarnya TIDAK akan terhapus.');">
            @csrf
            @method('DELETE')
            <button type_submit" class="btn btn-outline-danger shadow-sm">
                <i class="fas fa-trash-alt me-2"></i> Hapus Jadwal Kosong
            </button>
        </form>
        
        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary shadow-sm">
            <i class="fa-solid fa-plus me-2"></i> Tambah Jadwal Baru
        </a>
    </div>
</div>

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

<div class="content-card">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>Judul Sesi</th>
                    <th>Dokter</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Pendaftar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->title }}</td>
                    <td>{{ $schedule->doctor->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->tanggal_praktek)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}</td>
                    <td>
                        <span class="badge bg-info">{{ $schedule->appointments_count ?? 0 }} / {{ $schedule->kuota }}</span>
                    </td>
                    <td>
                        @if($schedule->status == 'Tersedia')
                            <span class="badge bg-success">Tersedia</span>
                        @elseif($schedule->status == 'Penuh')
                            <span class="badge bg-danger">Penuh</span>
                        @else
                            <span class="badge bg-secondary">{{ $schedule->status }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('admin.jadwal.edit', $schedule->id) }}" class="btn btn-sm btn-warning me-2" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.jadwal.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada jadwal yang dibuat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection