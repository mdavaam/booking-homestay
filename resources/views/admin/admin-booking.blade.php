<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin - Booking</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<body>

        @include('layouts.sidebar-top')


  <!-- Content -->
  <div class="content">
    <div class="card mt-1 shadow-sm">
      <div class="card-body">
        <h5 class="card-title mb-3">Booking</h5>

        <form method="POST" action="#">
          @csrf
          <div class="row g-3">
            <div class="col-md-6">
              <label for="guestName" class="form-label">Nama Tamu</label>
              <input type="text" class="form-control" id="guestName" name="guest_name" required>
            </div>

            <div class="col-md-6">
              <label for="telepon" class="form-label">Telepon</label>
              <input type="telepon" class="form-control" id="telepon" name="telepon" required>
            </div>

            <div class="col-md-6">
              <label for="checkin" class="form-label">Check-in</label>
              <input type="date" class="form-control" id="checkin" name="checkin" required>
            </div>

            <div class="col-md-6">
              <label for="checkout" class="form-label">Check-out</label>
              <input type="date" class="form-control" id="checkout" name="checkout" required>
            </div>

            <div class="col-md-6">
              <label for="room" class="form-label">Tipe Kamar</label>
              <select class="form-select" id="room" name="room" required>
                <option disabled selected>Pilih kamar</option>
                <option value="Standard">Standard</option>
                <option value="Deluxe">Deluxe</option>
                <option value="Family">Family</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="status" class="form-label">Pembayaran</label>
              <select class="form-select" id="status" name="status" required>
                <option value="pending">Cash</option>
                <option value="paid">Cashless</option>
              </select>
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane me-2"></i>
              </button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script ></script>
</body>
</html>
