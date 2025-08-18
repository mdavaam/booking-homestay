<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">

    <div class="card p-4 rounded-4 shadow" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4">
            <h4 class="fw-bold">Setel Ulang Password</h4>
            <p class="text-muted">Masukkan password baru untuk akun Anda</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ request()->email }}">

            <div class="mb-3">
                <label for="newPassword" class="form-label">Password Baru</label>
                <div class="input-group">
                    <input type="password" name="password" id="newPassword" class="form-control rounded-start-3" required>
                    <button type="button" class="btn btn-outline-secondary rounded-end-3 toggle-password" data-target="newPassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                    <input type="password" name="password_confirmation" id="confirmPassword" class="form-control rounded-start-3" required>
                    <button type="button" class="btn btn-outline-secondary rounded-end-3 toggle-password" data-target="confirmPassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn w-100 py-2 mt-2 rounded-pill text-white fw-semibold" style="background-color: #3f3fff;">
                Ubah Password
            </button>

            <p class="text-center mt-3">
                Sudah ingat password? <a href="{{ route('login') }}" class="text-primary fw-semibold">Login di sini</a>
            </p>
        </form>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>

</body>
</html>
