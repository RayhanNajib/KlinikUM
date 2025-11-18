@extends('layouts.app')

@section('title', 'Manajemen Dokter')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0" style="color: var(--primary-color);">Manajemen Dokter</h1>
    <a href="{{ route('admin.dokter.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-2"></i> Tambah Akun Dokter
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="content-card">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>Nama Dokter</th>
                    <th>Email</th>
                    <th>Spesialisasi</th>
                    <th>NIP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($doctors as $doctorUser)
                <tr>
                    <td>{{ $doctorUser->name }}</td>
                    <td>{{ $doctorUser->email }}</td>
                    <td>{{ optional($doctorUser->doctor)->specialties }}</td>
                    <td>{{ optional($doctorUser->doctor)->nip ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.dokter.edit', $doctorUser->id) }}" class="btn btn-sm btn-warning me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.dokter.destroy', $doctorUser->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus dokter ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data dokter.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection