<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin - Orders</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('css/main.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</head>

<body>

        @include('layouts.sidebar-top')

{{-- main content --}}

<div class="container-fluid py-4">
  <div class="content">
    <div class="card-body" style="overflow: visible;">
        <h5 class="card-title mb-4 fw-semibold">Laporan Pemesanan</h5>
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered">

                <div class="d-flex justify-content-between align-items-center mb-4">
  <h5 class="card-title fw-semibold mb-0">Recent Bookings</h5>
  <a href="{{ route('printpdf') }}" target="_blank" class="btn btn-outline-primary">
    <i class="fas fa-print me-1"></i> Print PDF
  </a>
</div>


<form method="GET" class="row gy-3 gx-2 align-items-end mb-4">
    <!-- Input kalender -->
    <div class="col-md-4">
        <label for="daterange" class="form-label">Tanggal</label>
        <input type="text" name="daterange" id="daterange" class="form-control" placeholder="dd-mm-yyyy - dd-mm-yyyy" value="{{ request('daterange') }}">
    </div>

    <!-- Filter waktu -->
    <div class="col-md-3">
        <select name="filter" id="filter" class="form-select">
            <option value="">-- Pilih --</option>
            <option value="7" {{ request('filter') == 7 ? 'selected' : '' }}>7 Hari Terakhir</option>
            <option value="30" {{ request('filter') == 30 ? 'selected' : '' }}>30 Hari Terakhir</option>
            <option value="90" {{ request('filter') == 90 ? 'selected' : '' }}>90 Hari Terakhir</option>
        </select>
    </div>

    <!-- Tombol filter -->
   <br> <div class="col-md-2">
        <button type="submit" class="btn btn-primary btn-sm w-100">
            <i class="fas fa-search me-1"></i> Filter
        </button>
    </div>

    <!-- Tombol reset -->
    <div class="col-md-2">
        <a href="{{ route('laporan.transaksi') }}" class="btn btn-outline-secondary btn-sm w-100">
            Reset
        </a>
    </div>
</form>


    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Kode Transaksi</th>
                    <th>Customer</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal Transaksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $i => $trx)
                    <tr>
                        <td>{{ $transactions->firstItem() + $i }}</td>
                        <td>{{ $trx->kode_transaksi }}</td>
                        <td>{{ $trx->user->name ?? '-' }}</td>
                        <td>{{ $trx->check_in }}</td>
                        <td>{{ $trx->check_out }}</td>
                        <td>Rp{{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                        <td>
                            @if ($trx->status == 'success')
                                <span class="badge bg-success">Success</span>
                            @elseif ($trx->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @else
                                <span class="badge bg-danger">Failed</span>
                            @endif
                        </td>
                        <td>{{ $trx->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $transactions->withQueryString()->links() }}
    </div>
</div>


  <!-- Bootstrap JS and Popper.js from CDN -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script>
  flatpickr("#daterange", {
      mode: "range",
      dateFormat: "d-m-Y",
      locale: {
        firstDayOfWeek: 1 // Start with Monday
      }
  });
</script>



</body>

</html>
