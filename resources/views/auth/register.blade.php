<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun - DigitalCreativeHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .register-container {
            display: flex;
            min-height: 100vh;
        }

        /* Bagian Kiri - Branding */
        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, #5B6CFF 0%, #6A82FB 100%);
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(80px);
        }

        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            filter: blur(60px);
        }

        .left-content {
            position: relative;
            z-index: 1;
            color: white;
        }

        .brand-logo {
            width: 56px;
            height: 56px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 40px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .brand-logo i {
            font-size: 28px;
            color: white;
        }

        .brand-title {
            font-size: 48px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 24px;
            color: white;
        }

        .brand-description {
            font-size: 18px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.9);
            max-width: 480px;
        }

        .left-footer {
            position: relative;
            z-index: 1;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            font-weight: 500;
        }

        /* Bagian Kanan - Form */
        .right-panel {
            flex: 1;
            background: #ffffff;
            padding: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-container {
            width: 100%;
            max-width: 440px;
        }

        .form-header {
            margin-bottom: 40px;
        }

        .form-title {
            font-size: 32px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 8px;
        }

        .form-subtitle {
            font-size: 15px;
            color: #718096;
            line-height: 1.5;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            height: 48px;
            border-radius: 10px;
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

        .form-control.is-invalid {
            border-color: #fc8181;
        }

        .invalid-feedback {
            font-size: 13px;
            color: #e53e3e;
            margin-top: 6px;
        }

        .btn-primary-custom {
            height: 50px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            background: linear-gradient(135deg, #5B6CFF 0%, #6A82FB 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .login-link {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #718096;
        }

        .login-link a {
            color: #5B6CFF;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .register-container {
                flex-direction: column;
            }

            .left-panel {
                min-height: 300px;
                padding: 40px 30px;
            }

            .brand-title {
                font-size: 36px;
            }

            .brand-description {
                font-size: 16px;
            }

            .left-footer {
                text-align: center;
            }

            .right-panel {
                padding: 40px 30px;
            }

            .form-title {
                font-size: 28px;
            }
        }

        @media (max-width: 576px) {
            .left-panel {
                padding: 30px 20px;
            }

            .right-panel {
                padding: 30px 20px;
            }

            .brand-title {
                font-size: 28px;
            }

            .form-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Bagian Kiri - Branding -->
        <div class="left-panel">
            <div class="left-content">
                <div class="brand-logo" style="background: white; width: 80px; height: 80px;">
                    <img src="{{ asset('images/logo.png') }}" alt="DigitalCreativeHub" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <h1 class="brand-title">Halo, Selamat Datang di DigitalCreativeHub!</h1>
                <p class="brand-description">
                    Platform layanan produk dan desain digital untuk kreator, mahasiswa, dan UMKM.
                </p>
            </div>
            <div class="left-footer">
                ©{{ date('Y') }} DigitalCreativeHub
            </div>
        </div>

        <!-- Bagian Kanan - Form Registrasi -->
        <div class="right-panel">
            <div class="form-container">
                <!-- Header Form -->
                <div class="form-header">
                    <h2 class="form-title">Buat Akun Baru</h2>
                    <p class="form-subtitle">Daftarkan akun Anda untuk mulai menggunakan layanan DigitalCreativeHub.</p>
                </div>

                <!-- Pesan Error -->
                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-3 mb-4">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <strong>Perhatian!</strong> Mohon perbaiki kesalahan berikut:
                        <ul class="mb-0 mt-2 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Registrasi -->
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    
                    <!-- Nama Lengkap -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input 
                            type="text" 
                            class="form-control @error('name') is-invalid @enderror" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}" 
                            placeholder="Masukkan nama lengkap Anda" 
                            required 
                            autofocus
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Alamat Email -->
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
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                                placeholder="Minimal 8 karakter" 
                                required
                            >
                            <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y" onclick="togglePassword('password', 'toggleIcon1')" style="text-decoration: none; padding: 0 12px; z-index: 10;">
                                <i class="bi bi-eye" id="toggleIcon1" style="color: #a0aec0;"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Konfirmasi Kata Sandi -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <div class="position-relative">
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                placeholder="Masukkan ulang kata sandi Anda" 
                                required
                            >
                            <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y" onclick="togglePassword('password_confirmation', 'toggleIcon2')" style="text-decoration: none; padding: 0 12px; z-index: 10;">
                                <i class="bi bi-eye" id="toggleIcon2" style="color: #a0aec0;"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Daftar -->
                    <button type="submit" class="btn btn-primary-custom w-100">
                        Daftar Sekarang
                    </button>
                </form>

                <!-- Link Login -->
                <div class="login-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            
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
