@extends('layouts.app')

@section('title', 'Edit Jadwal Praktek')

@section('content')
<h1 class="h3 mb-4" style="color: var(--primary-color);">Edit Jadwal Praktek</h1>

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

    <form action="{{ route('admin.jadwal.update', $schedule->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Pilih Dokter</label>
                <select name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror">
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}" 
                            {{ (old('doctor_id', $schedule->doctor_id) == $doctor->id) ? 'selected' : '' }}>
                            {{ $doctor->user->name }} ({{ $doctor->specialties }})
                        </option>
                    @endforeach
                </select>
                @error('doctor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Judul Sesi</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Misal: Sesi Pagi Umum" 
                       value="{{ old('title', $schedule->title) }}">
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Praktek</label>
                <input type="date" name="tanggal_praktek" class="form-control @error('tanggal_praktek') is-invalid @enderror" 
                       value="{{ old('tanggal_praktek', $schedule->tanggal_praktek) }}">
                @error('tanggal_praktek') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Kuota Pasien</label>
                <input type="number" name="kuota" class="form-control @error('kuota') is-invalid @enderror" 
                       value="{{ old('kuota', $schedule->kuota) }}">
                @error('kuota') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jam Mulai</label>
                <input type="time" name="jam_mulai" class="form-control @error('jam_mulai') is-invalid @enderror" 
                       value="{{ old('jam_mulai', \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i')) }}">
                @error('jam_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Jam Selesai</label>
                <input type="time" name="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror" 
                       value="{{ old('jam_selesai', \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i')) }}">
                @error('jam_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Status Jadwal</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="Tersedia" {{ (old('status', $schedule->status) == 'Tersedia') ? 'selected' : '' }}>Tersedia</option>
                    <option value="Penuh" {{ (old('status', $schedule->status) == 'Penuh') ? 'selected' : '' }}>Penuh</option>
                    <option value="Selesai" {{ (old('status', $schedule->status) == 'Selesai') ? 'selected' : '' }}>Selesai</option>
                </select>
                @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection