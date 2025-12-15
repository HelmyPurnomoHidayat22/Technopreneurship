@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    {{-- Back Button --}}
    <div class="mb-3">
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row g-4 justify-content-center">
        {{-- Profile Edit Form --}}
        <div class="col-12 col-lg-10 col-xl-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-person-circle me-2 text-primary"></i>Edit Profil
                    </h4>
                    <p class="text-muted small mb-0 mt-1">Perbarui informasi profil Anda</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('user.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        {{-- Informasi Utama --}}
                        <div class="row g-3">
                            {{-- Nama Lengkap --}}
                            <div class="col-12">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="bi bi-person me-1"></i>Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name', $user->name) }}" 
                                    required
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Email --}}
                            <div class="col-12">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-1"></i>Alamat Email <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email', $user->email) }}" 
                                    required
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        {{-- Ubah Password Section --}}
                        <h6 class="fw-bold mb-2">Ubah Password (Opsional)</h6>
                        <p class="text-muted small mb-3">Kosongkan jika tidak ingin mengubah password</p>
                        
                        <div class="row g-3">
                            {{-- Password Baru --}}
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="bi bi-lock me-1"></i>Password Baru
                                </label>
                                <div class="position-relative">
                                    <input 
                                        type="password" 
                                        class="form-control @error('password') is-invalid @enderror" 
                                        id="password" 
                                        name="password" 
                                        placeholder="Minimal 8 karakter"
                                    >
                                    <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y" onclick="togglePassword('password', 'toggleIcon1')" style="text-decoration: none; padding: 0 12px; z-index: 10;">
                                        <i class="bi bi-eye" id="toggleIcon1" style="color: #a0aec0;"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Konfirmasi Password --}}
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold">
                                    <i class="bi bi-lock me-1"></i>Konfirmasi Password Baru
                                </label>
                                <div class="position-relative">
                                    <input 
                                        type="password" 
                                        class="form-control" 
                                        id="password_confirmation" 
                                        name="password_confirmation" 
                                        placeholder="Ulangi password baru"
                                    >
                                    <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y" onclick="togglePassword('password_confirmation', 'toggleIcon2')" style="text-decoration: none; padding: 0 12px; z-index: 10;">
                                        <i class="bi bi-eye" id="toggleIcon2" style="color: #a0aec0;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        {{-- Catatan / Preferensi --}}
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-semibold">
                                <i class="bi bi-pencil me-1"></i>Catatan / Preferensi
                            </label>
                            <textarea 
                                class="form-control @error('notes') is-invalid @enderror" 
                                id="notes" 
                                name="notes" 
                                rows="4" 
                                placeholder="Contoh: preferensi desain, warna favorit, kebutuhan khusus, dll."
                            >{{ old('notes', $user->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Maksimal 1000 karakter</small>
                        </div>
                        
                        {{-- Submit Buttons --}}
                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4 order-2 order-sm-1">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-4 order-1 order-sm-2">
                                <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
@endsection
