@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">📄 Input Arsip Baru</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('archives.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="nomor_akta" class="form-label">Nomor Akta</label>
                                <input type="text" name="nomor_akta"
                                    class="form-control @error('nomor_akta') is-invalid @enderror"
                                    value="{{ old('nomor_akta') }}" required>
                                @error('nomor_akta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nama_klien" class="form-label">Nama Klien</label>
                                <input type="text" name="nama_klien"
                                    class="form-control @error('nama_klien') is-invalid @enderror"
                                    value="{{ old('nama_klien') }}" required>
                                @error('nama_klien')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="kategori_id" class="form-label">Jenis Dokumen</label>
                                        <select name="kategori_id" id="kategori_id"
                                            class="form-select @error('kategori_id') is-invalid @enderror" required>
                                            <option value="">-- Jenis Dokumen --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('kategori_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="jenis_dokumen" id="jenis_dokumen"
                                            class="form-control mt-2 d-none" readonly>
                                        @error('kategori_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <script>
                                            document.getElementById('kategori_id').addEventListener('change', function() {
                                                const selectedOption = this.options[this.selectedIndex];
                                                document.getElementById('jenis_dokumen').value = selectedOption.text;
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_akta" class="form-label">Tanggal Akta</label>
                                <input type="date" name="tanggal_akta"
                                    class="form-control @error('tanggal_akta') is-invalid @enderror"
                                    value="{{ old('tanggal_akta') }}" required>
                                @error('tanggal_akta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="lampiran" class="form-label">Lampiran (PDF)</label>
                                <input type="file" name="lampiran"
                                    class="form-control @error('lampiran') is-invalid @enderror" accept=".pdf" required>
                                <div class="form-text">Maksimal ukuran file: 2MB</div>
                                @error('lampiran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('archives.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Arsip
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
