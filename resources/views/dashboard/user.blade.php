@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>📁 Dashboard Pengguna</h2>
    <p>Selamat datang, {{ Auth::user()->name }}! Anda login sebagai <strong>User</strong>.</p>

    <ul>
        <li><a href="#">🔍 Cari Arsip</a></li>
        <li><a href="#">🧾 Input Data Arsip</a></li>
    </ul>
</div>
@endsection