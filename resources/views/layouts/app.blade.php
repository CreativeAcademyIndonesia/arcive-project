<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Arsip Notaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">


</head>

<body>

    <!-- Navbar Utama -->
    <nav class="navbar navbar-dark bg-dark px-3">
        <span class="navbar-brand mb-0 h1">📄 Arsip Notaris</span>
        <div>
            <a href="{{ route('archives.create') }}" class="btn btn-outline-light btn-sm">+ Input Arsip</a>
            <a href="{{ route('archives.index') }}" class="btn btn-outline-light btn-sm">📂 Lihat Arsip</a>
        </div>
    </nav>

    <!-- Isi Konten -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Menangani pesan sukses
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        // Menangani pesan error
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
            });
        @endif

        // Menangani pesan warning
        @if (session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian!',
                text: "{{ session('warning') }}",
            });
        @endif

        // Menangani pesan info
        @if (session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: "{{ session('info') }}",
            });
        @endif

        // Konfirmasi Delete
        function confirmDelete(event, form) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>

</body>

</html>
