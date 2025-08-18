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

    <style>

.btn-modern-danger {
    background-color: #dc3545 !important;
    color: white !important;


}

.btn-modern-success {
    background-color: #22c55e;
    color: #ffffff;
}
.btn-modern-success:hover {
    background-color: #16a34a;
    color: #ffffff;
}

        .sidebar {
            background: linear-gradient(180deg, #ffffff, #f1f5f9);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        .sidebar-item {
            text-decoration: none;
            color: #1e293b;
            display: flex;
            align-items: center;
            padding: 15px 20px;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .sidebar-item:hover {
            background-color: #f1f5f9;
            border-left-color: #3b82f6;
        }
        .sidebar-item.active {
            background-color: #e0f2fe;
            border-left-color: #3b82f6;
            font-weight: 600;
        }
        .sidebar-item i {
            margin-right: 12px;
            font-size: 1.2rem;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 1.5rem;
        }
        .booking-item {
            display: flex;
            align-items: center;
            padding: 1.25rem;
            border-bottom: 1px solid #f1f5f9;
            transition: background-color 0.2s ease;
        }
        .booking-item:hover {
            background-color: #f8fafc;
        }
        .booking-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 1.5rem;
        }
        .booking-details {
            flex-grow: 1;
        }
        .booking-details strong {
            color: #1e293b;
            font-weight: 600;
        }
        .booking-actions {
            margin-top: 1rem;
            display: flex;
            gap: 0.75rem;
        }
.btn-modern {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.95rem;
    border: none;
    transition: background-color 0.3s ease, transform 0.2s ease;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    cursor: pointer;
}

.btn-modern:hover {
    transform: translateY(-1px);


}



        .status-pending {
            color: #f59e0b;
            font-weight: 500;
        }
        @media (max-width: 767px) {
            .booking-item {
                flex-direction: column;
                align-items: flex-start;
            }
            .booking-img {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    @include('layouts.navbar')

    <!-- Sidebar dan Konten -->
    <section>
        <div class="container py-5">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-4 mb-4">
                    <div class="sidebar">
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
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 fw-bold">My Bookings</h5>
                        </div>
                        <div class="card-body">
                            @if($pesananku->isEmpty())
                                <p class="text-muted mb-0">You have no booking history yet.</p>
                            @else
                                <div class="list-group list-group-flush">
                                    @foreach($pesananku as $pesanan)
                                        <div class="booking-item">
                                            <!-- Tampilkan gambar kamar jika ada -->
                                            @if($pesanan->kamar && $pesanan->kamar->photo_utama)
                                                <img src="{{ asset('storage/' . $pesanan->kamar->photo_utama) }}"
                                                     alt="Kamar {{ $pesanan->kamar->nama_kamar }}"
                                                     class="booking-img">
                                            @else
                                                <img src="{{ asset('images/default-room.jpg') }}"
                                                     alt="Default Kamar"
                                                     class="booking-img">
                                            @endif

                                            <div class="booking-details">
                                                <strong>Nama Kamar:</strong> {{ $pesanan->kamar->nama_kamar ?? '-' }} <br>
                                                <strong>Kode Transaksi:</strong> {{ $pesanan->kode_transaksi }} <br>
                                                <strong>Total Pembayaran:</strong> Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }} <br>
                                                <strong>Status:</strong>
                                                <span class="{{ $pesanan->status === 'pending' ? 'status-pending' : '' }}">
                                                    {{ $pesanan->status }}
                                                </span>
                                            </div>
                                        </div>
                                        @if($pesanan->status === 'pending')
                                            <div class="booking-actions">
                                                <form action="{{ route('batalkan.pesanann', $pesanan->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn-modern btn-modern-danger">
                                                        <i class="fas fa-times-circle me-1"></i> Batalkan
                                                    </button>

                                                </form>
                                    @php
                                        $kodeUrl = str_replace('TRX-', '', $pesanan->kode_transaksi);
                                    @endphp

                                <a href="{{ route('pembayaran.lanjut', $kodeUrl) }}" class="btn-modern btn-modern-success">
                                    <i class="fas fa-credit-card me-1"></i> Pembayaran
                                            </a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
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
