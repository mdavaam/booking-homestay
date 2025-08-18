<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Status Transaksi</title>
</head>
<body style="background-color: #f3f4f6; font-family: sans-serif; margin: 0; padding: 0;">
  <div style="max-width: 600px; margin: 30px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">

    <div style="background: linear-gradient(to right, #3b82f6, #6366f1); color: white; text-align: center; padding: 30px;">
      <h2 style="font-size: 24px; font-weight: bold;">Halo {{ $transaksi->nama_pemesan }},</h2>
    </div>

    <div style="padding: 30px; color: #1f2937;">
      @if ($transaksi->status === 'pending')
        <p style="font-size: 16px; margin-bottom: 16px;">Terima kasih telah memesan di <strong>Homestay Putih Mulia</strong>!</p>
        <p style="font-size: 16px; margin-bottom: 16px;">
          Transaksi Anda <strong style="color: #facc15;">Menunggu Pembayaran</strong>
        </p>
        <p style="margin-bottom: 24px;">Selesaikan pembayaran kamu sekarang untuk mengamankan pemesanan:</p>
        <a href="https://app.sandbox.midtrans.com/snap/v2/vtweb/{{ $transaksi->snap_token }}"
           style="display: inline-block; background: #10b981; color: white; font-weight: bold; padding: 12px 24px; border-radius: 9999px; text-decoration: none;">
          Lanjutkan Pembayaran
        </a>


      @elseif ($transaksi->status === 'success' || $transaksi->status === 'settlement')
        <p style="font-size: 16px; margin-bottom: 16px;">🎉 <strong>Pemesanan kamu berhasil!</strong></p>
        <p style="margin-bottom: 16px;">Kode Transaksi: <strong style="color: #3b82f6;">{{ $transaksi->kode_transaksi }}</strong></p>
        <p>Terima kasih telah memilih <strong>Homestay Putih Mulia</strong>! Kami tunggu kedatangan kamu 🙏</p>

      @elseif ($transaksi->status === 'expired')
        <p style="font-size: 16px; margin-bottom: 16px;">😞 <strong>Transaksi kamu gagal diproses.</strong></p>
        <p style="margin-bottom: 16px;">Kode Transaksi: <strong style="color: #ef4444;">{{ $transaksi->kode_transaksi }}</strong></p>
        <p style="margin-bottom: 16px;">Penyebab umum: Pembayaran tidak dilakukan tepat waktu atau dibatalkan.</p>
        <p style="margin-bottom: 24px;">Jangan khawatir! Kamu bisa melakukan pemesanan ulang kapan saja melalui platform kami.</p>

      @endif
    </div>

    <div style="background: #f9fafb; text-align: center; padding: 20px; border-top: 1px solid #e5e7eb;">
      <p style="color: #6b7280; font-size: 12px;">Homestay Putih Mulia © {{ date('Y') }}</p>
    </div>

  </div>
</body>
</html>
