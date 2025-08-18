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
        <h5 class="card-title mb-4 fw-semibold">Status Pemesanan</h5>
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered">

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Kode Transaksi</th>
                    <th>Customer</th>
                    <th>Tanggal Transaksi</th>
                    <th>Status</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>

                </tr>
            </thead>
            <tbody>
@forelse ($transaksi as $i => $trx)
    @if ($trx->status !== 'pending')
        @continue
    @endif
    <tr>
        <td>{{ $transaksi->firstItem() + $i }}</td>
        <td>{{ $trx->kode_transaksi }}</td>
        <td>{{ $trx->user->name ?? '-' }}</td>
        <td>{{ $trx->tanggal_transaksi }}</td>
        <td><span class="badge bg-warning text-dark text-capitalize">{{ $trx->status }}</span></td>
        <td>Rp{{ number_format($trx->total_harga, 0, ',', '.') }}</td>

        <td>
            <div class="booking-actions">
                <form action="{{ route('batalkan-pesanan', $trx->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                        <i class="fas fa-times-circle me-1"></i> Batalkan
                    </button>
                </form>

                <a href="{{ route('pembayaran.lanjutan', $trx->kode_transaksi) }}" class="btn btn-success btn-sm">
    <i class="fas fa-credit-card me-1"></i>Pembayaran
</a>

            </div>
        </td>
    </tr>
    <td>
@empty
    <tr>
        <td colspan="8" class="text-center">Tidak ada data transaksi.</td>
    </tr>
@endforelse
</td>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $transaksi->withQueryString()->links() }}
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
