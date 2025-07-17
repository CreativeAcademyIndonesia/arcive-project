@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Backup & Restore Database</h5>
                        <form action="{{ route('backup.create') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-download"></i> Buat Backup Baru
                            </button>
                        </form>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal Backup</th>
                                        <th>Nama File</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($backups as $backup)
                                        <tr>
                                            <td>{{ $backup->created_at->format('d/m/Y H:i:s') }}</td>
                                            <td>{{ $backup->file_name }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $backup->status === 'success' ? 'success' : 'danger' }}">
                                                    {{ $backup->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <form action="{{ route('backup.restore', $backup->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-warning btn-sm"
                                                        onclick="return confirm('Anda yakin ingin mengembalikan database ke backup ini? Semua data setelah tanggal backup ini akan hilang.')">
                                                        <i class="fas fa-undo"></i> Restore
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Belum ada backup yang tersedia.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
