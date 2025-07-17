@extends('layouts.app')

@section('content')
    <h2>Riwayat Akses</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Dokumen</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($accessLogs as $index => $log)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $log->archive->nomor_akta }} - {{ $log->archive->nama_klien }}</td>
                    <td>{{ ucfirst($log->action) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada riwayat akses</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
