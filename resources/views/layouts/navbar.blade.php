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
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <h5>Putih Mulia</h5>
            </a>

            <!-- Tombol toggle untuk tampilan mobile -->
            <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="toggler-icon">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="bar top-bar" d="M5 7H25" stroke="#333" stroke-width="2" stroke-linecap="round"/>
                        <path class="bar middle-bar" d="M5 15H25" stroke="#333" stroke-width="2" stroke-linecap="round"/>
                        <path class="bar bottom-bar" d="M5 23H25" stroke="#333" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </span>
            </button>

            <!-- Menu navigasi collapse -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
<li class="nav-item dropdown position-relative">
    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="{{ asset('images/avatar.png') }}" alt="Avatar" class="rounded-circle me-2" width="24" height="24">

        {{-- Notifikasi Badge --}}
        @if(isset($notifikasiUser) && $notifikasiUser->count() > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $notifikasiUser->count() }}
            </span>
        @endif
    </a>

    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileDropdown">
        <li>
            <h6 class="dropdown-header">Selamat datang!</h6>
        </li>
        <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fa fa-user me-2"></i> Profil</a></li>
        <li>
    <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('myBookings') }}">
        <span><i class="fa-solid fa-cart-shopping"></i>&nbsp;&nbsp;My Booking</span>
        @if(isset($notifikasiUser) && $notifikasiUser->count() > 0)
            <span class="badge bg-danger rounded-pill" style="font-size: 0.65rem; padding: 2px 3px;">
                {{ $notifikasiUser->count() }}
            </span>
        @endif
    </a>
</li>

        <li><hr class="dropdown-divider"></li>
        <li>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button class="dropdown-item text-danger" type="submit"><i class="fa fa-sign-out-alt me-2"></i> Logout</button>
            </form>
        </li>
    </ul>
</li>

                </ul>
            </div>
        </div>
    </nav>
