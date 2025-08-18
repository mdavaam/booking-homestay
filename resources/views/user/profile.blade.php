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
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>
<body>
    @include('layouts.navbar')

<!-- Sidebar dan Konten -->
<section style="min-height: 100vh;">
    <div class="container py-5">
<div class="row d-flex align-items-start">
            <!-- Sidebar -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 sidebar">
                    <div class="card-body p-0">
                        <a href="{{ route('profile') }}" class="sidebar-item {{ request()->routeIs('profile') ? 'active' : '' }}" aria-label="View Profile">
                            <i class="fa fa-user"></i> Profile
                        </a>
                        <a href="{{ route('myBookings') }}" class="sidebar-item {{ request()->routeIs('myBookings') ? 'active' : '' }}" aria-label="View My Bookings">
                            <i class="fa fa-history"></i> My Bookings
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-8">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">Profile</h5>
                    </div>
                    <div class="card-body">
                        <div class="profile-header">
                            <div class="profile-info">
                                <img src="{{ asset('images/avatar.png') }}" alt="Profile Avatar" class="rounded-circle">
                                <div class="ms-3">
                                    <h5>{{ Auth::user()->name }}</h5>
                                    <p class="text-muted">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success mt-3">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            <div class="row mt-4">
                                <div class="col-md-6 mb-3">
                                    <label for="fullName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="name" id="fullName" value="{{ Auth::user()->name }}" placeholder="Your Full Name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->email }}" disabled>
                                </div>
                                <div class="col-12 mt-2">
                                    <button type="submit" class="btn-modern">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
