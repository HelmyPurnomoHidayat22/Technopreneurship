@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
{{-- Page Header --}}
<div class="page-header mb-4">
    <h2 class="fw-bold mb-2">
        <i class="bi bi-grid-3x3-gap me-2 text-primary"></i>Katalog Produk
    </h2>
    <p class="text-muted mb-0">Temukan produk digital berkualitas untuk proyek kreatif Anda</p>
</div>

{{-- Filter & Search --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('products.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="category" class="form-label fw-semibold">
                    <i class="bi bi-funnel me-1"></i>Kategori
                </label>
                <select name="category" id="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="search" class="form-label fw-semibold">
                    <i class="bi bi-search me-1"></i>Cari Produk
                </label>
                <input type="text" 
                       name="search" 
                       id="search" 
                       class="form-control" 
                       placeholder="Cari berdasarkan nama atau deskripsi..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel-fill me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Products Grid --}}
@if($products->count() > 0)
    <div class="row g-4">
        @foreach($products as $product)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card product-card h-100 shadow-sm border-0">
                    {{-- Product Image --}}
                    <div class="position-relative overflow-hidden" style="height: 220px; background: linear-gradient(135deg, #5B6CFF 0%, #6A82FB 100%);">
                        @if($product->preview_image)
                            <img src="{{ $product->preview_image_url }}" 
                                 class="w-100 h-100" 
                                 alt="{{ $product->title }}" 
                                 style="object-fit: cover; transition: transform 0.5s ease;">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-white">
                                <i class="bi bi-image fs-1 opacity-50"></i>
                            </div>
                        @endif
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-primary shadow-sm">{{ $product->category->name }}</span>
                        </div>
                    </div>
                    
                    {{-- Product Info --}}
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-2" style="min-height: 48px; line-height: 1.4;">
                            {{ Str::limit($product->title, 60) }}
                        </h5>
                        <p class="card-text text-muted small flex-grow-1 mb-3" style="min-height: 60px; line-height: 1.6;">
                            {{ Str::limit($product->description, 100) }}
                        </p>
                        <div class="mt-auto pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <span class="text-muted small d-block">Harga</span>
                                    <span class="h4 fw-bold text-primary mb-0">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-primary w-100">
                                <i class="bi bi-eye me-2"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($products->hasPages())
        <div class="mt-5 pt-4 border-top">
            <div class="pagination-info mb-3 text-center">
                Menampilkan <strong>{{ $products->firstItem() ?? 0 }}</strong> sampai <strong>{{ $products->lastItem() ?? 0 }}</strong> dari <strong>{{ $products->total() }}</strong> produk
            </div>
            <nav aria-label="Product pagination" class="d-flex justify-content-center">
                {{ $products->links() }}
            </nav>
        </div>
    @endif
@else
    {{-- Empty State --}}
    <div class="card shadow-sm">
        <div class="card-body text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
            <h5 class="text-muted mb-2">Produk tidak ditemukan</h5>
            <p class="text-muted mb-0">Coba ubah kriteria pencarian atau filter Anda</p>
        </div>
    </div>
@endif
@endsection
