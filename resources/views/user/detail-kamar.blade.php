<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homestay Putih Mulia</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" href="{{ asset('images/favicon-180.png') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>


    </style>

</head>
<body>
@auth
    {{-- Jika user sudah login --}}
    @include('layouts.navbar')
@endauth

@guest
    {{-- Jika user belum login --}}
    @include('layouts.logindaftar')
@endguest    <!-- Hero Section -->

<div class="container my-5">
    <h4 class="mb-4 fw-bold">Daftar Kamar</h4>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($kamars as $kamar)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 position-relative">
                    <!-- Gambar Kamar -->
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $kamar->photo_utama) }}"
                             class="card-img-top rounded-top"
                             alt="Foto Kamar"
                             style="height: 230px; object-fit: cover;">

                        @if($kamar->status !== 'tersedia')
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex justify-content-center align-items-center">
                                <span class="badge bg-danger p-2 fs-6">NOT AVAILABLE</span>
                            </div>
                        @endif
                    </div>

                    <!-- Body Kartu -->
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-semibold">{{ $kamar->nama_kamar }}</h5>
                        <p class="text-muted small mb-2">{{ Str::limit(strip_tags($kamar->deskripsi), 90) }}</p>
                        <p class="fw-semibold text-primary">Rp {{ number_format($kamar->harga_permalam, 0, ',', '.') }}/malam</p>
                        <div class="mt-auto">
                            @if($kamar->status === 'tersedia')
                                    <a href="{{ route('pesan.kamar', $kamar->nama_kamar) }}" class="btn btn-book-now w-100">
                                        <i class="fa fa-bed me-2"></i> Book Now
                                    </a>
                            @else
                                <button class="btn btn-secondary w-100" disabled>Not Available</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


    @include('layouts.footer')
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</body>
</html>
