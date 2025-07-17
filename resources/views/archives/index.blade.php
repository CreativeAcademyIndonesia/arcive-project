@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Daftar Arsip</h2>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Filter Pencarian</h5>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label for="nama_klien" class="form-label">Nama Klien</label>
                        <input type="text" name="nama_klien" id="nama_klien" value="{{ request('nama_klien') }}"
                            class="form-control" placeholder="Masukkan nama klien">
                    </div>
                    <div class="col-md-3">
                        <label for="nomor_akta" class="form-label">Nomor Akta</label>
                        <input type="text" name="nomor_akta" id="nomor_akta" value="{{ request('nomor_akta') }}"
                            class="form-control" placeholder="Masukkan nomor akta">
                    </div>
                    <div class="col-md-3">
                        <label for="tanggal_akta" class="form-label">Tanggal Akta</label>
                        <input type="date" name="tanggal_akta" id="tanggal_akta" value="{{ request('tanggal_akta') }}"
                            class="form-control">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="btn-group" role="group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            <a href="{{ route('archives.index') }}" class="btn btn-secondary">
                                <i class="fas fa-sync"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nomor Akta</th>
                                <th>Nama Klien</th>
                                <th>Jenis Dokumen</th>
                                <th>Tanggal Akta</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($archives as $arsip)
                                <tr>
                                    <td>{{ $arsip->nomor_akta }}</td>
                                    <td>{{ $arsip->nama_klien }}</td>
                                    <td>{{ $arsip->jenis_dokumen }}</td>
                                    <td>{{ \Carbon\Carbon::parse($arsip->tanggal_akta)->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('archives.view-pdf', $arsip) }}"
                                                class="btn btn-sm btn-success" target="_blank">
                                                <i class="fas fa-eye"></i> Preview
                                            </a>
                                            <a href="{{ route('archives.download', $arsip) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                            <form action="{{ route('archives.destroy', $arsip) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus arsip ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data arsip yang ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $archives->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .btn-group {
            gap: 5px;
        }

        .table td {
            vertical-align: middle;
        }
    </style>
@endpush
