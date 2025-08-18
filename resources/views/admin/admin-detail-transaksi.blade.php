<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin - Orders</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>

<body>

        @include('layouts.sidebar-top')

{{-- main content --}}

<div class="container-fluid py-4">
  <div class="content">
    <div class="card-body" style="overflow: visible;">
        <h5 class="card-title mb-4 fw-semibold">Recent Bookings</h5>
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered">
              <tr>
                <th>Kode Transaksi</th>
                <td>{{ $transaksi->kode_transaksi }}</td>
              </tr>
              <tr>
                <th>Customer</th>
                <td>{{ $transaksi->nama_pemesan ?? '-' }}</td>
              </tr>
              <tr>
                <th>Kebangsaan</th>
                <td>{{ $transaksi->kebangsaan }}</td>
              </tr>
              <tr>
                <th>Kode Negara</th>
                <td>{{ $transaksi->kode_negara ?? '-' }}</td>
              </tr>
              <tr>
                <th>No HP</th>
                <td>{{ $transaksi->nohp ?? '-' }}</td>
              </tr>
              <tr>
                <th>Email</th>
                <td>{{ $transaksi->user->email ?? '-' }}</td>
              </tr>
              <tr>
                <th>Nama Kamar</th>
                <td>{{ $transaksi->kamar->nama_kamar ?? '-' }}</td>
              </tr>
              <tr>
                <th>Total Harga</th>
                <td>Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
              </tr>
              <tr>
                <th>Check-In</th>
                <td>{{ $transaksi->check_in }}</td>
              </tr>
              <tr>
                <th>Check-Out</th>
                <td>{{ $transaksi->check_out }}</td>
              </tr>
              <tr>
                <th>Status</th>
                <td>
                  <span class="badge bg-{{ $transaksi->status == 'success' ? 'success' : ($transaksi->status == 'pending' ? 'warning' : 'danger') }}">
                    {{ ucfirst($transaksi->status) }}
                  </span>
                </td>
              </tr>
              <tr>
                <th>Metode Pembayaran</th>
                <td>{{ strtoupper($transaksi->metode_pembayaran) }}</td>
              </tr>
              <tr>
                <th>Tanggal Transaksi</th>
                <td>{{ $transaksi->tanggal_transaksi }}</td>
              </tr>
              <tr>
                <th>Tanggal Pembayaran</th>
                <td>{{ $transaksi->tanggal_pembayaran ?? '-' }}</td>
              </tr>
              <tr>
                <th>Accepted By</th>
                <td>{{ $transaksi->admin->name ?? '-' }}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
    </div>
    </div>
    </div>




  <!-- Bootstrap JS and Popper.js from CDN -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>



</body>

</html>
