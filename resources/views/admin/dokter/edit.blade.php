@extends('layouts.app')

@section('title', 'Edit Data Dokter')

@section('content')
<h1 class="h3 mb-4" style="color: var(--primary-color);">Edit Data: {{ data_get($user, 'name') }}</h1>

<div class="content-card">
    <form action="{{ route('admin.dokter.update', data_get($user, 'id')) }}" method="POST">
        @csrf
        @method('PUT')
        
        <h5 class="mb-3">Informasi Akun (Login)</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Lengkap Dokter</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', data_get($user, 'name')) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Email (Untuk Login)</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', data_get($user, 'email')) }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="row">
             <div class="col-md-6 mb-3">
                <label class="form-label">Password Baru (Opsional)</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Isi jika ingin ganti password">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">No. Handphone</label>
                <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', data_get($user, 'no_hp')) }}" required>
                @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <hr class="my-4">
        <h5 class="mb-3">Informasi Detail Dokter</h5>
        
         <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Spesialisasi</label>
                <input type="text" name="specialties" class="form-control @error('specialties') is-invalid @enderror" value="{{ old('specialties', data_get($user, 'doctor.specialties')) }}" required>
                @error('specialties') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">NIP (Opsional)</label>
                <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip', data_get($user, 'doctor.nip')) }}">
                @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Perbarui Data Dokter</button>
            <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection