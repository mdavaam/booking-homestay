<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homestay Putih Mulia</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


</head>

<body>

  @auth
    {{-- Jika user sudah login --}}
    @include('layouts.navbar')
@endauth

@guest
    {{-- Jika user belum login --}}
    @include('layouts.logindaftar')
@endguest

    <!-- Hero Section -->
    <section class="hero-section position-relative">
        <!-- Gambar Background -->
        <div class="hero-bg">
            <img src="images/background1.jpg" class="bg-slide active" alt="Slide 1">
            <img src="images/background2.jpg" class="bg-slide" alt="Slide 2">
            <img src="images/background3.jpg" class="bg-slide" alt="Slide 3">
        </div>


        <!-- Konten -->
        <div class="container position-relative z-2 text-white text-center">
            <h1 class="display-4 fw-bold">Pesan Penginapan Terbaik Anda</h1>
            <p class="lead">Tempat Nyaman, Harga Aman!</p>
            <div class="search-box mt-4">
                    <form action="{{ route('filter.kamar') }}" method="GET">
    <div class="row g-3 align-items-center justify-content-center">
        <div class="col-md-4">
            <input type="text" class="form-control" placeholder="Temukan kamar berdasarkan tipe kamar!" name="destination" id="destination">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="checkin" id="checkin" placeholder="Check-in" value="{{ request('checkin') }}">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="checkout" id="checkout" placeholder="Check-out" value="{{ request('checkout') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Search</button>
        </div>
    </div>
</form>

            </div>
        </div>
    </section>


    <!-- Promo Section -->
<section class="promo-section">
    <div class="container py-5">
    <h4>Hasil Pencarian Kamar</h4>

    @foreach($kamarsByTipe as $tipe => $kamars)
        <h5 class="mt-4">{{ $tipe }}</h5>
           <br> <div class="row row-cols-1 row-cols-md-3 g-4">
    @forelse($kamars as $kamar)
        <div class="col">
            <div class="card h-100 border-0 shadow-sm position-relative">
                <!-- Gambar kamar -->
                <div class="position-relative">
                    <img src="{{ asset('storage/' . $kamar->photo_utama) }}" class="card-img-top rounded-top" alt="Kamar">
                    <span class="badge bg-primary position-absolute top-0 end-0 m-2">{{ $tipe }}</span>
                </div>
                <!-- Body -->
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title fw-semibold mb-1">Kamar {{ $kamar->nama_kamar }}</h6>
                    <p class="text-muted small mb-2">{{ $kamar->fasilitas }}</p>
                    <p class="fw-semibold text-primary">Rp {{ number_format($kamar->harga_permalam, 0, ',', '.') }}/malam</p>
                    <a href="{{ route('detail.kamar', $kamar->id) }}" class="btn-book-now mt-auto">
                        <i class="fa fa-eye me-2"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Tidak ada kamar tersedia di tipe ini.</p>
    @endforelse
</div>
@endforeach

</section>
    @include('layouts.footer')
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#checkin", {
    dateFormat: "Y-m-d"
});
flatpickr("#checkout", {
    dateFormat: "Y-m-d"
});

    </script>
    <script>
        document.getElementById('checkin').addEventListener('change', function () {
    console.log('Check-in:', this.value);
});
document.getElementById('checkout').addEventListener('change', function () {
    console.log('Check-out:', this.value);
});

    </script>
</body>
</html>
