@extends('layouts.main')

@section('title', 'Pendaftaran Pasien')

@section('body-class', 'auth-split-layout')

@push('page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endpush

@section('content')
<div class="auth-wrapper" >

    <div class="auth-form-panel">
        <div class="auth-form-content">
            <div class="text-center text-md-start mb-4">
                <h2 class="header-text">Pendaftaran Akun Baru</h2>
                <p class="sub-text">Lengkapi data diri sesuai KTM/KTP</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger text-start">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-12 mb-3 text-start">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="input-text" placeholder="Nama sesuai identitas" required value="{{ old('name') }}">
                    </div>

                    <div class="col-md-6 mb-3 text-start">
                        <label class="form-label">Email (Akun Siakad/Aktif)</label>
                        <input type="email" name="email" class="input-text" placeholder="nama@...ac.id" required value="{{ old('email') }}">
                    </div>
                    
                    <div class="col-md-6 mb-3 text-start">
                        <label class="form-label">No. WhatsApp</label>
                        <input type="text" name="no_hp" class="input-text" placeholder="08..." required value="{{ old('no_hp') }}">
                    </div>

                    <div class="col-12 mb-3 text-start">
                        <label class="form-label">NIM / NIK (Identitas Kampus)</label>
                        <input type="text" name="nim_nik" class="input-text" placeholder="Nomor Induk Mahasiswa / Karyawan" required value="{{ old('nim_nik') }}">
                    </div>
                    
                    <div class="col-md-6 mb-3 text-start">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="input-text" required value="{{ old('tgl_lahir') }}">
                    </div>

                    <div class="col-md-6 mb-3 text-start">
                        <label class="form-label">Kata Sandi</label>
                        <input type="password" name="password" class="input-text" placeholder="Minimal 8 karakter" required>
                    </div>
                    
                    <div class="col-12 mb-3 text-start">
                        <label class="form-label">Alamat Domisili (Malang)</label>
                        <textarea name="alamat" class="input-text" rows="2" placeholder="Alamat kos / asrama / rumah di Malang" required>{{ old('alamat') }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-auth w-100 mt-3">Daftar Sekarang</button>
            </form>

            <div class="mt-4 text-center">
                <p class="sub-text" style="font-size: 1rem;">Sudah punya akun? <a href="{{ route('login') }}" class="hover-link1">Masuk disini</a></p>
            </div>
        </div>
    </div>
    
    <div class="auth-image-panel">
    </div>

</div>
@endsection