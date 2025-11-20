@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')

@php /** @var \App\Models\User $user */ @endphp

<h1 class="h3 mb-4" style="color: var(--primary-color);">Pengaturan Akun</h1>

<div class="row">
    <div class="col-lg-6">
        <div class="content-card">
            <h5 class="mb-4">Edit Profil</h5>

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="text-center mb-4">
                    <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Foto Profil" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                </div>

                <div class="mb-3">
                    <label for="avatar" class="form-label">Ganti Foto Profil (Opsional)</label>
                    <input class="form-control @error('avatar') is-invalid @enderror" type="file" id="avatar" name="avatar">
                    @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="content-card">
            <h5 class="mb-4">Ganti Password</h5>
            
            @if(session('success_password'))
            <div class="alert alert-success">
                {{ session('success_password') }}
            </div>
            @endif

            @if($errors->updatePassword->any())
                <div class="alert alert-danger">
                    @foreach ($errors->updatePassword->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('profile.password.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="current_password" class="form-label">Password Saat Ini</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary">Ubah Password</button>
            </form>
        </div>
    </div>
</div>
@endsection