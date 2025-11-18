@extends('layouts.app')

@section('title', 'Manajemen Pasien')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0" style="color: var(--primary-color);">Manajemen Pasien</h1>
    <a href="{{ route('admin.pasien.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-2"></i> Tambah Akun Pasien
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
                    <th>Nama Pasien</th>
                    <th>Email</th>
                    <th>NIM/NIK</th>
                    <th>No. HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($patients as $patientUser)
                <tr>
                    <td>{{ $patientUser->name }}</td>
                    <td>{{ $patientUser->email }}</td>
                    <td>{{ optional($patientUser->patient)->nim_nik }}</td>
                    <td>{{ $patientUser->no_hp }}</td>
                    <td>
                        <a href="{{ route('admin.pasien.edit', $patientUser->id) }}" class="btn btn-sm btn-warning me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.pasien.destroy', $patientUser->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pasien ini?');">
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
                    <td colspan="5" class="text-center">Belum ada data pasien.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection