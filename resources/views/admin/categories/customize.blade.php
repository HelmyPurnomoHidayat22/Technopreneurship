@extends('layouts.admin')

@section('title', 'Customisasi Kategori')

@section('content')
<div class="container-fluid py-4">
    {{-- Page Header --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Kategori</a></li>
                <li class="breadcrumb-item active">Customisasi</li>
            </ol>
        </nav>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-gear me-2 text-primary"></i>Customisasi Kategori: {{ $category->name }}
        </h2>
        <p class="text-muted mb-0">Atur tampilan dan informasi kategori</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            {{-- Customization Form --}}
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <form action="{{ route('admin.categories.updateCustomization', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Catatan Kategori --}}
                        <div class="mb-4">
                            <label for="note" class="form-label fw-semibold">
                                Catatan Kategori
                            </label>
                            <textarea 
                                class="form-control @error('note') is-invalid @enderror" 
                                id="note" 
                                name="note" 
                                rows="4" 
                                placeholder="Tambahkan deskripsi atau catatan untuk kategori ini"
                            >{{ old('note', $category->note) }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Maksimal 1000 karakter</small>
                        </div>

                        {{-- Custom Style (Badge Color) --}}
                        <div class="mb-4">
                            <label for="custom_style" class="form-label fw-semibold">
                                Warna Badge
                            </label>
                            <select 
                                class="form-select @error('custom_style') is-invalid @enderror" 
                                id="custom_style" 
                                name="custom_style"
                            >
                                <option value="">Default (Abu-abu)</option>
                                <option value="bg-primary" {{ old('custom_style', $category->custom_style) == 'bg-primary' ? 'selected' : '' }}>Biru</option>
                                <option value="bg-success" {{ old('custom_style', $category->custom_style) == 'bg-success' ? 'selected' : '' }}>Hijau</option>
                                <option value="bg-danger" {{ old('custom_style', $category->custom_style) == 'bg-danger' ? 'selected' : '' }}>Merah</option>
                                <option value="bg-warning" {{ old('custom_style', $category->custom_style) == 'bg-warning' ? 'selected' : '' }}>Kuning</option>
                                <option value="bg-info" {{ old('custom_style', $category->custom_style) == 'bg-info' ? 'selected' : '' }}>Cyan</option>
                                <option value="bg-dark" {{ old('custom_style', $category->custom_style) == 'bg-dark' ? 'selected' : '' }}>Hitam</option>
                            </select>
                            @error('custom_style')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Warna badge yang ditampilkan di katalog produk</small>
                        </div>

                        {{-- Icon --}}
                        <div class="mb-4">
                            <label for="icon" class="form-label fw-semibold">
                                Icon (Bootstrap Icons)
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('icon') is-invalid @enderror" 
                                id="icon" 
                                name="icon" 
                                value="{{ old('icon', $category->icon) }}" 
                                placeholder="Contoh: tag, folder, box"
                            >
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Nama icon dari <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a> (tanpa prefix "bi-")
                            </small>
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-circle me-2"></i>Simpan Customisasi
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary px-4">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Preview Card --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-eye me-2 text-primary"></i>Preview
                    </h6>
                    
                    <div class="border rounded-3 p-3 mb-3">
                        <h6 class="fw-bold mb-2">
                            @if($category->icon)
                                <i class="bi bi-{{ $category->icon }} me-2"></i>
                            @endif
                            {{ $category->name }}
                        </h6>
                        <span class="badge {{ $category->custom_style ?? 'bg-secondary' }} rounded-pill">
                            Kategori
                        </span>
                        @if($category->note)
                            <p class="text-muted small mt-2 mb-0">{{ Str::limit($category->note, 80) }}</p>
                        @endif
                    </div>

                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Preview akan diperbarui setelah menyimpan
                    </small>
                </div>
            </div>

            {{-- Icon Guide --}}
            <div class="card shadow-sm border-0 rounded-3 mt-3">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Icon Populer</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-light text-dark"><i class="bi bi-tag me-1"></i>tag</span>
                        <span class="badge bg-light text-dark"><i class="bi bi-folder me-1"></i>folder</span>
                        <span class="badge bg-light text-dark"><i class="bi bi-box me-1"></i>box</span>
                        <span class="badge bg-light text-dark"><i class="bi bi-star me-1"></i>star</span>
                        <span class="badge bg-light text-dark"><i class="bi bi-heart me-1"></i>heart</span>
                        <span class="badge bg-light text-dark"><i class="bi bi-bookmark me-1"></i>bookmark</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
