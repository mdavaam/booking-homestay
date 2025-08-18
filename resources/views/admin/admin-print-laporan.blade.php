<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Laporan Pemesanan</title>
  <style>
    body { font-family: sans-serif; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #000; padding: 6px; text-align: center; }
    th { background-color: #eee; }
  </style>
</head>
<body>
  <h2 style="text-align: center;">Laporan Pemesanan Kamar</h2>
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Customer</th>
        <th>Kamar</th>
        <th>Check-In</th>
        <th>Check-Out</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($transaksi as $index => $trx)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $trx->user->name ?? '-' }}</td>
        <td>{{ $trx->kamar->nama_kamar ?? '-' }}</td>
        <td>{{ $trx->check_in }}</td>
        <td>{{ $trx->check_out }}</td>
        <td>{{ is_null($trx->acceptedby) ? 'Pending' : 'Disetujui' }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
