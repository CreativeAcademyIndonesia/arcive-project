@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-5">
        <div class="card shadow-lg p-4 rounded-4">
            <div class="card-body">
                <h3 class="text-center mb-4">🔐 Login Sistem Arsip Notaris</h3>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Ingat Saya</label>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">🔓 Login</button>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('register') }}">Belum punya akun?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection