@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-5">
        <div class="card shadow-lg p-4 rounded-4">
            <div class="card-body">
                <h3 class="text-center mb-4">📝 Daftar Akun Pegawai</h3>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" class="form-control" name="password" required>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Sandi</label>
                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-success">🧾 Daftar</button>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('login') }}">Sudah punya akun? Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection