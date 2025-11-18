@extends('layouts.main')

@section('title', 'Masuk Sistem')

@section('body-class', 'auth-split-layout')

@push('page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endpush

@section('content')
<div class="auth-wrapper" >

    <div class="auth-form-panel">
        <div class="auth-form-content">
            <div class="text-center text-md-start mb-5">
                <h2 class="header-text">Selamat Datang!</h2>
                <p class="sub-text">Portal Layanan Klinik Pratama UM</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf 
                <div class="mb-3 text-start">
                    <label class="form-label">Email (Akun Siakad/Pegawai)</label>
                    <input type="email" name="email" class="input-text" placeholder="nama@um.ac.id" required>
                </div>

                <div class="mb-3 text-start">
                    <label class="form-label">Kata Sandi</label>
                    <input type="password" name="password" class="input-text" placeholder="********" required>
                </div>

                <button type="submit" class="btn btn-auth w-100 mt-3">Masuk</button>
            </form>

            <div class="mt-4 text-center">
                <p class="sub-text" style="font-size: 1rem;">Belum punya akun? <a href="{{ route('register') }}" class="hover-link1">Daftar Baru</a></p>
            </div>
        </div>
    </div>

    <div class="auth-image-panel">
    </div>

</div>
@endsection