@extends('layouts.admin')

@section('title', 'Detail Produk')

@section('content')
{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-box-seam me-2 text-primary"></i>Detail Produk
        </h2>
        <p class="text-muted mb-0">Informasi lengkap produk</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    {{-- Product Info --}}
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-info-circle me-2 text-primary"></i>Informasi Produk
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-12">
                        <label class="text-muted small">Judul Produk</label>
                        <h4 class="fw-bold mb-0">{{ $product->title }}</h4>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="text-muted small">Kategori</label>
                        <p class="mb-0">
                            <span class="badge bg-primary rounded-pill fs-6">{{ $product->category->name }}</span>
                        </p>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="text-muted small">Harga</label>
                        <h4 class="text-primary fw-bold mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
                    </div>
                    
                    <div class="col-12">
                        <label class="text-muted small">Deskripsi</label>
                        <p class="mb-0" style="line-height: 1.8;">{{ $product->description }}</p>
                    </div>
                    
                    @if($product->preview_image)
                        <div class="col-12">
                            <label class="text-muted small">Preview Image</label>
                            <div class="mt-2">
                                <img src="{{ $product->preview_image_url }}" 
                                     class="img-fluid rounded shadow-sm" 
                                     alt="Preview" 
                                     style="max-width: 500px;">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 sticky-top" style="top: 100px;">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-bar-chart me-2 text-primary"></i>Statistik
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="display-6 fw-bold text-primary">{{ $product->orders->where('status', 'paid')->count() }}</div>
                    <small class="text-muted">Total Penjualan</small>
                </div>
                <hr>
                <div class="small">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Pesanan</span>
                        <strong>{{ $product->orders->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Pending</span>
                        <strong>{{ $product->orders->where('status', 'pending')->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Menunggu Verifikasi</span>
                        <strong>{{ $product->orders->where('status', 'waiting_verification')->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Lunas</span>
                        <strong class="text-success">{{ $product->orders->where('status', 'paid')->count() }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
