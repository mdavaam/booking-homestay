<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin - Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<body>

        @include('layouts.sidebar-top')

{{-- main content --}}

<div class="content">
  <div class="row">
    <div class="col-md-4 mb-4">
      <div class="card shadow-sm p-3 bg-white">
        <div class="card-body">
          <h5><i class="fas fa-receipt text-primary me-2"></i>Total Order</h5>
          <p class="text-muted fs-5">{{ $totalOrder}}</p>

        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card shadow-sm p-3 bg-white">
        <div class="card-body">
          <h5><i class="fas fa-bed text-success me-2"></i>Available Rooms</h5>
          <p class="text-muted fs-5">{{ $kamarTersedia }}</p>
        </div>
      </div>
    </div>

  <!-- Tabel Booking dengan Search -->
  <div class="card shadow-sm bg-white">
    <div class="card-body">
      <h5 class="card-title mb-4">
        <i class="fas fa-calendar-check me-2"></i>Recent Bookings
      </h5>
      <div class="mb-3">
<input type="text" id="searchInput" class="form-control mb-3" placeholder="Cari nama user..." value="{{ request('search') }}">
      <div class="table-responsive">
        <table class="table table-hover align-middle" id="bookingTable">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Customer</th>
              <th>Room</th>
              <th>Check-In</th>
              <th>Check-Out</th>
            </tr>
          </thead>
          <tbody>
                @foreach ($dashboard as $data )
                <tr>
                  <td>{{ $data->id }}</td>
                    <td>{{ $data->user->name }}</td>
                  <td><span class="badge bg-primary">{{ $data->kamar->nama_kamar }}</span></td>
                  <td>{{ $data->check_in }}</td>
                  <td>{{ $data->check_out }}</td>
                </tr>
                @endforeach    <!-- Tambahkan baris lain di sini -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script src="{{ asset('js/main.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
let timeout = null;

document.getElementById('searchInput').addEventListener('keyup', function () {
    clearTimeout(timeout);

    let search = this.value;

    timeout = setTimeout(function () {
        // Redirect ke URL dengan query string pencarian
        window.location.href = `?search=${encodeURIComponent(search)}`;
    }, 500); // Tunggu 500ms setelah mengetik berhenti
});
</script>

</body>
</html>
