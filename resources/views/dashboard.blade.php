@extends('layouts.app')

@section('content')
    <div class="py-4">
        <div class="container">

            <!-- Kotak sambutan -->
            <div class="bg-white p-4 shadow rounded mb-4">
                <h2 class="h5">Dashboard Admin</h2>
                <p>Selamat datang, Admin Notaris! Anda login sebagai <strong>Admin</strong>.</p>
            </div>

            <!-- Tombol Navigasi -->
            <div class="mb-4 d-flex gap-2 flex-wrap">
                <a href="{{ route('archives.index') }}" class="btn btn-primary">Kelola Arsip</a>
                <a href="{{ route('kategori.index') }}" class="btn btn-warning text-white">Kelola Kategori</a>
                <a href="{{ route('logs.index') }}" class="btn btn-info text-white">Riwayat Akses</a>
                <a href="{{ route('backup.index') }}" class="btn btn-success">Backup / Restore</a>
            </div>

            <!-- Tabel Arsip Terbaru -->
            <div class="bg-white p-4 shadow rounded mb-4">
                <h4>📝 Arsip Terbaru Ditambahkan</h4>
                <table class="table table-bordered mt-3">
                    <thead class="table-light">
                        <tr>
                            <th>No. Akta</th>
                            <th>Nama Klien</th>
                            <th>Jenis Dokumen</th>
                            <th>Tanggal Akta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestArchives as $archive)
                            <tr>
                                <td>{{ $archive->nomor_akta }}</td>
                                <td>{{ $archive->nama_klien }}</td>
                                <td>{{ $archive->jenis_dokumen }}</td>
                                <td>{{ \Carbon\Carbon::parse($archive->tanggal_akta)->format('d F Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada arsip terbaru</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tabel Daftar Arsip -->
            <div class="bg-white p-4 shadow rounded">
                <h4>📂 Daftar Arsip Lengkap</h4>
                <table class="table table-bordered mt-3">
                    <thead class="table-light">
                        <tr>
                            <th>No. Akta</th>
                            <th>Nama Klien</th>
                            <th>Jenis Dokumen</th>
                            <th>Tanggal Akta</th>
                            <th>Lampiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allArchives as $archive)
                            <tr>
                                <td>{{ $archive->nomor_akta }}</td>
                                <td>{{ $archive->nama_klien }}</td>
                                <td>{{ $archive->jenis_dokumen }}</td>
                                <td>{{ \Carbon\Carbon::parse($archive->tanggal_akta)->format('d F Y') }}</td>
                                <td>
                                    @if ($archive->lampiran)
                                        <a href="{{ route('archives.view-pdf', $archive) }}"
                                            class="btn btn-sm btn-outline-primary" target="_blank">Lihat PDF</a>
                                    @else
                                        <span class="text-muted">Tidak ada lampiran</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada arsip tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
