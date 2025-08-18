
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
</head>
<body style="background-color: #f3f4f6; font-family: sans-serif; margin: 0; padding: 0;">
  <div style="max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">

    <div style="background: linear-gradient(to right, #3b82f6, #6366f1); color: white; text-align: center; padding: 30px;">
      <h2 style="font-size: 24px; font-weight: bold;">Reset Password Akun Anda</h2>
    </div>

    <div style="padding: 30px; color: #1f2937;">
      <p style="font-size: 16px; margin-bottom: 16px;">Halo, kami menerima permintaan untuk mengatur ulang password akun Anda.</p>
      <p style="font-size: 16px; margin-bottom: 24px;">Klik tombol di bawah ini untuk melanjutkan proses reset password:</p>

      <a href="{{ $url }}"
         style="display: inline-block; background: #10b981; color: white; font-weight: bold; padding: 12px 24px; border-radius: 9999px; text-decoration: none;">
        Reset Password
      </a>

      <p style="font-size: 14px; margin-top: 30px; color: #6b7280;">
        Jika Anda tidak pernah meminta reset password, silakan abaikan email ini.
      </p>
    </div>

    <div style="background: #f9fafb; text-align: center; padding: 20px; border-top: 1px solid #e5e7eb;">
      <p style="color: #6b7280; font-size: 12px;">Homestay Putih Mulia © {{ date('Y') }}</p>
      <p style="color: #9ca3af; font-size: 12px;">Bantuan? Hubungi <a href="mailto:support@homestayputihmulia.com" style="color: #3b82f6; text-decoration: none;">support@homestayputihmulia.com</a></p>
    </div>

  </div>
</body>
</html>
