<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - DigitalCreativeHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #5B6CFF 0%, #6A82FB 100%);
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,101.3C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            pointer-events: none;
        }

        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-logo {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #5B6CFF 0%, #6A82FB 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .login-logo i {
            font-size: 32px;
            color: white;
        }

        .login-title {
            font-size: 28px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 8px;
        }

        .login-subtitle {
            font-size: 15px;
            color: #718096;
            font-weight: 400;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .form-control {
            height: 48px;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            padding: 12px 16px;
            font-size: 15px;
            transition: all 0.2s ease;
            background: #ffffff;
        }

        .form-control:focus {
            border-color: #5B6CFF;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .form-control::placeholder {
            color: #a0aec0;
        }

        .form-check {
            padding-left: 1.75rem;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            border: 1.5px solid #cbd5e0;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #5B6CFF;
            border-color: #5B6CFF;
        }

        .form-check-label {
            font-size: 14px;
            color: #4a5568;
            cursor: pointer;
            margin-left: 4px;
        }

        .btn-login {
            height: 48px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            background: linear-gradient(135deg, #5B6CFF 0%, #6A82FB 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #5568d3 0%, #6a3f8f 100%);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .register-link {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #718096;
        }

        .register-link a {
            color: #5B6CFF;
            font-weight: 600;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .footer-text {
            text-align: center;
            margin-top: 24px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background: #fee;
            color: #c53030;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 32px 24px;
            }

            .login-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="login-logo" style="background: transparent; box-shadow: none; border: none;">
                    <img src="{{ asset('images/logo.png') }}" alt="DigitalCreativeHub" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <h1 class="login-title">Selamat Datang</h1>
                <p class="login-subtitle">Masuk ke akun Anda</p>
            </div>

            <!-- Pesan Error -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <!-- Form Login -->
            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="nama@email.com" 
                        required 
                        autofocus
                    >
                </div>

                <!-- Kata Sandi -->
                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <div class="position-relative">
                        <input 
                            type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            id="password" 
                            name="password" 
                            placeholder="Masukkan kata sandi Anda" 
                            required
                        >
                        <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y" onclick="togglePassword()" style="text-decoration: none; padding: 0 12px;">
                            <i class="bi bi-eye" id="toggleIcon" style="color: #a0aec0;"></i>
                        </button>
                    </div>
                </div>

                <!-- Ingat Saya -->
                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Ingat Saya
                    </label>
                </div>

                <!-- Tombol Masuk -->
                <button type="submit" class="btn btn-login w-100">
                    Masuk
                </button>
            </form>

            <!-- Link Daftar -->
            <div class="register-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-text">
            ©{{ date('Y') }} DigitalCreativeHub
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>
