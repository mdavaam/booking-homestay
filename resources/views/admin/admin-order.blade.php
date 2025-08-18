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
        <div class="d-flex justify-content-between align-items-center mb-4">
  <h5 class="card-title fw-semibold mb-0">Recent Bookings</h5>
  <div class="d-flex">
    <a href="{{ route('laporan.transaksi') }}" class="btn btn-outline-primary ms-auto">
        <i class="fas fa-file-alt me-2"></i>
    </a>
</div>
</div>

        <div class="mb-4">
          <input type="text" id="searchInput" class="form-control" placeholder="cari berdasarkan nama customer...">
        </div>

        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle" id="ordersTable">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Nomor Kamar</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Status</th>
                <th>Action</th>
                <th>Accepted By</th>
                <th>Detail</th>

              </tr>
            </thead>
            <tbody>
    @forelse ($orders as $index => $trx)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $trx->user->name ?? '-' }}</td>
        <td><span class="badge bg-primary">{{ $trx->kamar->nama_kamar ?? '-' }}</span></td>
        <td>{{ $trx->check_in }}</td>
        <td>{{ $trx->check_out }}</td>

        <td>
  @if(is_null($trx->acceptedby) || $trx->acceptedby == '')
    <span class="badge bg-warning text-dark">Pending</span>
  @else
    <span class="badge bg-success">Disetujui</span>
  @endif
</td>


        </td>
        <td>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Kelola
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
<li>
    <form action="{{ route('orders.accept', $trx->id) }}" method="POST" onsubmit="return confirm('Yakin terima transaksi ini?')">
        @csrf
        <button type="submit" class="dropdown-item text-success">
            <i class="fas fa-check me-2"></i> Terima
        </button>
    </form>
</li>

                </ul>
            </div>
        </td>
        <td>{{ $trx->admin->name ?? '-' }}</td>
        <td>
        <a href="{{ route('detail.transaksi', $trx->id) }}" class="btn btn-sm  d-inline-flex align-items-center justify-content-center">
        <i class="fas fa-eye"></i></a>
    </td>
    </tr>

    @empty
    <tr>
        <td colspan="9" class="text-center">Tidak ada transaksi.</td>
    </tr>
    @endforelse
</tbody>

          </table>
        </div>

      </div>
    </div>
  </div>
</div>



  <!-- Bootstrap JS and Popper.js from CDN -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

  <script>
    // Function to handle order rejection
    function rejectOrder() {

      // Close modal after action
      var myModal = new bootstrap.Modal(document.getElementById('rejectModal'));
      myModal.hide();
    }

    // Function to handle order acceptance
    function acceptOrder() {

      // Close modal after action
      var myModal = new bootstrap.Modal(document.getElementById('acceptModal'));
      myModal.hide();
    }

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('#ordersTable tbody tr');

    searchInput.addEventListener('keyup', function () {
      const keyword = this.value.toLowerCase();
      tableRows.forEach(row => {
        const customer = row.cells[1].textContent.toLowerCase();
        row.style.display = customer.includes(keyword) ? '' : 'none';
      });
    });
  </script>

</body>

</html>
