@extends('layouts.app')

@section('title', 'Tambah Jadwal Baru')

@section('content')
<h1 class="h3 mb-4" style="color: var(--primary-color);">Tambah Jadwal Praktek Baru</h1>

<div class="content-card">
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Gagal menyimpan!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.jadwal.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Pilih Dokter</label>
                <select name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
                    <option value="" disabled selected>-- Pilih Dokter --</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->user->name }} ({{ $doctor->specialties }})
                        </option>
                    @endforeach
                </select>
                @error('doctor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Judul Sesi</label>
                <input type="text" name="title" class="form-control" placeholder="Misal: Sesi Pagi Umum" value="{{ old('title') }}" required>
            </div>
        </div>
        
        <hr class="my-3">
        <h5 class="mb-3">Atur Tanggal dan Perulangan</h5>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                    value="{{ old('tanggal_mulai') }}" required>
                @error('tanggal_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Selesai (Opsional)</label>
                <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                    value="{{ old('tanggal_selesai') }}">
                <div class="form-text">Kosongkan jika jadwal hanya untuk 1 hari (satu kali).</div>
                @error('tanggal_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="skip_weekends" name="skip_weekends" value="1" checked>
            <label class="form-check-label" for="skip_weekends">
                Lewati Hari Sabtu & Minggu (Libur)
            </label>
            <div class="form-text">Jika dicentang, jadwal tidak akan dibuat pada hari Sabtu/Minggu dalam rentang tanggal di atas.</div>
        </div>

        <hr class="my-3">
        <h5 class="mb-3">Atur Jam dan Kuota</h5>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jam Mulai</label>
                <input type="time" name="jam_mulai" class="form-control @error('jam_mulai') is-invalid @enderror" 
                    value="{{ old('jam_mulai') }}" required>
                @error('jam_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Jam Selesai</label>
                <input type="time" name="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror" 
                    value="{{ old('jam_selesai') }}" required>
                @error('jam_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Kuota Pasien (per hari)</label>
                <input type="number" name="kuota" class="form-control @error('kuota') is-invalid @enderror" 
                    value="{{ old('kuota', 10) }}" required>
                @error('kuota') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Buat Jadwal</button>
            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection