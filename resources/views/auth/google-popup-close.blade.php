<!DOCTYPE html>
<html>
<head>
    <title>Login Berhasil</title>
</head>
<body>
    <script>
        if (window.opener) {
            window.opener.location.href = "{{ $redirectRoute }}";
            window.close();
        } else {
            // fallback jika bukan dari popup
            window.location.href = "{{ $redirectRoute }}";
        }
    </script>
    <p>Login berhasil. Jika tidak otomatis ditutup, <a href="{{ $redirectRoute }}">klik di sini</a>.</p>
</body>
</html>
