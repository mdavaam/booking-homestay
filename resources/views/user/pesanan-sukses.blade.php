<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Berhasil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .checkmark {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #4CAF50;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 10px;
        }
        .checkmark::after {
            content: '\2713';
            color: white;
            font-size: 40px;
            font-weight: bold;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
        .details {
            text-align: left;
            font-size: 14px;
            color: #333;
        }
        .details div {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }
        .details .item {
            font-weight: bold;
        }
        .details .price {
            color: #333;
        }
        .details .total {
            font-weight: bold;
            color: #333;
        }
        .details .negative {
            color: #333;
        }
        .details hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 10px 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #00C4B4;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            font-size: 14px;
        }
        .btn:hover {
            background-color: #00b3a4;
        }
        .btn-back {
            display: inline-block;
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            font-size: 14px;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
        .button-group {
            margin-top: 20px;
        }
        @media (max-width: 600px) {
            .container {
                padding: 15px;
                margin: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="checkmark"></div>
        <div class="title">Pembelian Berhasil</div>
        <div class="details">
            <div>
                <span>Dipesan</span>
                <span>{{ $transaksi->created_at->translatedFormat('D, d M Y') }}</span>
            </div>
            <div>
                <span>Metode Pembayaran</span>
                <span>{{ ucfirst($transaksi->metode_pembayaran) }}</span>
            </div>
            <div>
                <span class="item">Total Harga</span>
                <span class="price">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
            </div>
            <hr>
            <div>
<span class="item"> {{ $transaksi->kamar->nama_kamar }} - ({{ $durasi }} malam)</span>
            </div>
        </div>
        <div class="button-group">
            <a href="/home" class="btn-back">Back</a>
        </div>
    </div>
</body>
</html>
