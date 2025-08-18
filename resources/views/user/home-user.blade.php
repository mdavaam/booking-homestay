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

</head>
<body>
    <!-- Navbar -->
@auth
    @include('layouts.navbar')
@endauth

@guest
    @include('layouts.logindaftar')
@endguest

    <!-- Hero Section -->
    <section class="hero-section position-relative">
        <!-- Gambar Background -->
        <div class="hero-bg">
            <img src="images/background1.jpg" class="bg-slide active" alt="Slide 1">
            <img src="images/background2.jpg" class="bg-slide" alt="Slide 2">
            <img src="images/background4.jpg" class="bg-slide" alt="Slide 3">
        </div>

        <!-- Tombol Navigasi -->
        <button class="slide-btn left">&#10094;</button>
        <button class="slide-btn right">&#10095;</button>

        <!-- Konten -->
        <div class="container position-relative z-2 text-white text-center">
            <h1 class="display-4 fw-bold">Pesan Penginapan Terbaik Anda</h1>
            <p class="lead">Tempat Nyaman, Harga Aman!</p>
            <div class="search-box mt-4">
                <form action="{{ route('filter.kamar') }}" method="GET">
    <div class="row g-3 align-items-center justify-content-center">
        <div class="col-md-4">
            <input type="text" class="form-control" placeholder="Find your favorite room" name="destination" id="destination">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="checkin" id="checkin" placeholder="Check-in">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="checkout" id="checkout" placeholder="Check-out">
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
    <div class="container">
        <h2 class="text-center mb-5">Temukan Penawaran Menarik</h2>
        <div class="row">
            @foreach($kamars as $kamar)
            <div class="col-md-4 mb-4">
                <div class="card promo-card h-100 d-flex flex-column">
                    <img src="{{ asset('storage/' . $kamar->photo_kamar) }}"
                         alt="Room Image"
                         style="width: 100%; height: 150px; object-fit: cover;"
                         class="card-img-top rounded">
                    <div class="card-body d-flex flex-column" style="min-height: 200px;">
                        <h5 class="card-title">{{ $kamar->jenis_kamar }}</h5>
                        <small class="text-muted" style="font-size: 12px;">Start From</small>
                        <h5 class="card-title">Rp. {{ $kamar->harga_permalam }}</h5>

                        <p class="card-text flex-grow-1">{{ $kamar->deskripsi }}</p>
                        <a href="{{ route('detail.kamar') }}?jenis_kamar={{ $kamar->jenis_kamar }}" class="btn btn-outline-primary mt-auto">Book Now</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>© {{ date('Y') }} Putih Mulia. All rights reserved.</p>
            <div>
                <a href="#" class="text-muted me-3">Privacy Policy</a>
                <a href="#" class="text-muted me-3">Terms of Service</a>
                <a href="#" class="text-muted">Contact Us</a>
            </div>
        </div>
    </footer>

    <!-- Login Modal -->
    <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="authModalLabel">Selamat Datang !</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tombol Login Sosial -->

                    <div class="social-login mb-3">
                        <a href="{{ url('/redirect') }}" class="btn btn-social btn-facebook w-100 mb-2">
                            <i class="fab fa-facebook-f me-2"></i> Login dengan Facebook
                        </a>
                        <button onclick="openGooglePopup('/redirect/google-login')" class="btn btn-social btn-google w-100 mb-2">
                            <i class="fab fa-google me-2"></i> Login dengan Google
                        </button>
                    </div>
                    <!-- Pemisah -->
                    <div class="divider my-3 text-center">
                        <span class="divider-text">dengan Email dan Password</span>
                    </div>
                    <!-- Login Form -->
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        @if ($errors->has('login_error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $errors->first('login_error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="loginEmail" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-rounded w-100">Login</button>
                        <p class="text-center mt-3">
                            Belum punya akun? <a href="#" class="switch-to-register text-primary" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Daftar di sini</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="registerModalLabel">Selamat Datang !</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tombol Register Sosial -->
                    <div class="social-login mb-3">
                        <a href="{{ url('/redirect/facebook') }}" class="btn btn-social btn-facebook w-100 mb-2">
                            <i class="fab fa-facebook-f me-2"></i> Daftar dengan Facebook
                        </a>
                        <button onclick="openGooglePopup('/redirect/google-register')" class="btn btn-social btn-google w-100">
                            <i class="fab fa-google me-2"></i> Daftar dengan Google
                        </button>
                    </div>
                    <!-- Pemisah -->
                    <div class="divider my-3 text-center">
                        <span class="divider-text">Atau daftar dengan Email</span>
                    </div>
                    <!-- Register Form -->
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="registerName" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="registerName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="registerEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="registerPassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerPasswordConfirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="registerPasswordConfirmation" name="password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-rounded w-100">Daftar</button>
                        <p class="text-center mt-3">
                            Sudah punya akun? <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#authModal" data-bs-dismiss="modal">Login di sini</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/main.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @if ($errors->has('login_error'))
<script>
    var myModal = new bootstrap.Modal(document.getElementById('authModal'));
    myModal.show();
</script>
@endif
</body>
</html>
