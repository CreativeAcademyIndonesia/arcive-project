@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="container">
        <h2 class="mb-4">📂 Kelola Arsip</h2>

        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach($archives as $type => $docs)
                <div class="col">
                    <div class="card shadow rounded">
                        <div class="card-header bg-primary text-white">
                            {{ $type }}
                        </div>
                        <div class="card-body">
                            @if(count($docs) > 0)
                                <ul class="list-group list-group-flush">
                                    @foreach($docs as $doc)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                <strong>{{ $doc->no_akta }}</strong> - {{ $doc->nama_klien }}
                                            </span>
                                            <a href="{{ asset('storage/'.$doc->file_pdf) }}" class="btn btn-sm btn-outline-primary" target="_blank">Lihat PDF</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Belum ada dokumen yang diinput.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
