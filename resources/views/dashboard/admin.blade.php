@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>👑 Dashboard Admin</h2>
    <p>Selamat datang, {{ Auth::user()->name }}! Anda login sebagai <strong>Admin</strong>.</p>

    <ul>
        <li><a href="#">📂 Kelola Arsip</a></li>
        <li><a href="#">📁 Kelola Kategori</a></li>
        <li><a href="#">🕓 Lihat Riwayat Akses</a></li>
        <li><a href="#">💾 Backup / Restore</a></li>
    </ul>
</div>
@endsection