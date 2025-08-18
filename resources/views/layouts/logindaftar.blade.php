    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container">
                <a class="navbar-brand" href="{{ route('welcome') }}">
                        <h5 class="fw-bold">Putih Mulia</h5>
                    </a>
            <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="toggler-icon">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="bar top-bar" d="M5 7H25" stroke="#333" stroke-width="2" stroke-linecap="round"/>
                        <path class="bar middle-bar" d="M5 15H25" stroke="#333" stroke-width="2" stroke-linecap="round"/>
                        <path class="bar bottom-bar" d="M5 23H25" stroke="#333" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <button class="nav-link btn btn-primary text-dark ms-3 btn-oval" data-bs-toggle="modal" data-bs-target="#authModal">Login | Daftar</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
     <!-- Login Modal -->
    <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="authModalLabel">Selamat Datang !</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tombol Login Sosial -->

                    <div class="social-login mb-3">
                        <button onclick="openGooglePopup('/redirect/google-login')" class="btn btn-social btn-google w-100 mb-2">
                            <i class="fab fa-google me-2"></i> Login dengan Google
                        </button>
                    </div>
                    <!-- Pemisah -->
                    <div class="divider my-3 text-center">
                        <span class="divider-text">dengan Email dan Password</span>
                    </div>
                    <!-- Login Form -->
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        @if ($errors->has('login_error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $errors->first('login_error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="loginEmail" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                        <label for="loginPassword" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="loginPassword" name="password" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="loginPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                        </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-rounded w-100">Login</button>
                        <p class="text-center mt-3">
                            Belum punya akun? <a href="#" class="switch-to-register text-primary" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Daftar di sini</a>
                        </p>
                        <p class="text-center mt-2">
                            <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#resetPasswordModal" data-bs-dismiss="modal">Lupa Password?</a>
                        </p>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Password Modal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="resetEmail" class="form-label">Masukkan Email Anda</label>
                        <input type="email" class="form-control" id="resetEmail" name="email" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Kirim Link Reset Password</button>
                    <p class="text-center mt-3"><a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#authModal" data-bs-dismiss="modal">Login di sini</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="registerModalLabel">Selamat Datang !</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tombol Register Sosial -->
                    <div class="social-login mb-3">
                        <button onclick="openGooglePopup('/redirect/google-register')" class="btn btn-social btn-google w-100">
                            <i class="fab fa-google me-2"></i> Daftar dengan Google
                        </button>
                    </div>
                    <!-- Pemisah -->
                    <div class="divider my-3 text-center">
                        <span class="divider-text">Atau daftar dengan Email</span>
                    </div>
                    <!-- Register Form -->
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="registerName" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="registerName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="registerEmail" name="email" required>
                        </div>
                       <div class="mb-3">
                        <label for="registerPassword" class="form-label">Password</label>
                        <div class="input-group">
                        <input type="password" class="form-control" id="registerPassword" name="password" required>
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="registerPassword">
                        <i class="fas fa-eye"></i>
                        </button>
                        </div>
                        </div>

                        <div class="mb-3">
                     <label for="registerPasswordConfirmation" class="form-label">Konfirmasi Password</label>
                    <div class="input-group">
                    <input type="password" class="form-control" id="registerPasswordConfirmation" name="password_confirmation" required>
                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="registerPasswordConfirmation">
                    <i class="fas fa-eye"></i>
                    </button>
                    </div>
                    </div>


                        <button type="submit" class="btn btn-primary btn-rounded w-100">Daftar</button>
                        <p class="text-center mt-3">
                            Sudah punya akun? <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#authModal" data-bs-dismiss="modal">Login di sini</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
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
