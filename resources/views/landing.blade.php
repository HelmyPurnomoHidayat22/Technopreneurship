@extends('layouts.public')

@section('title', 'DigitalCreativeHub - Template Digital Profesional')

@section('content')
{{-- Hero Section --}}
<section class="hero-section d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="display-3 fw-bold mb-4">
                    Solusi Desain Digital untuk Kebutuhan Kreatif Anda
                </h1>
                <p class="lead mb-5">
                    Template PPT, CV, Undangan, Notion, dan Custom Design Profesional
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg px-5">
                        <i class="bi bi-grid me-2"></i>Lihat Produk
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-5">
                        <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Features Section --}}
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">Mengapa Memilih Kami?</h2>
            <p class="text-muted">Keunggulan DigitalCreativeHub untuk kebutuhan desain Anda</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <div class="feature-icon bg-primary bg-opacity-10 text-primary mx-auto">
                        <i class="bi bi-palette"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Desain Profesional</h5>
                    <p class="text-muted small">Template berkualitas tinggi dibuat oleh desainer berpengalaman</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <div class="feature-icon bg-success bg-opacity-10 text-success mx-auto">
                        <i class="bi bi-lightning-charge"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Proses Cepat & Mudah</h5>
                    <p class="text-muted small">Download langsung setelah pembayaran terverifikasi</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <div class="feature-icon bg-warning bg-opacity-10 text-warning mx-auto">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Harga Terjangkau</h5>
                    <p class="text-muted small">Dapatkan template premium dengan harga yang kompetitif</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <div class="feature-icon bg-info bg-opacity-10 text-info mx-auto">
                        <i class="bi bi-file-earmark-check"></i>
                    </div>
                    <h5 class="fw-bold mb-2">File Siap Pakai</h5>
                    <p class="text-muted small">Format file yang mudah diedit dan siap digunakan</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Featured Products Section --}}
<section class="py-5">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">Produk Unggulan</h2>
            <p class="text-muted">Template digital terpopuler pilihan kami</p>
        </div>
        
        <div class="row g-4">
            @forelse($featuredProducts as $product)
                <div class="col-md-6 col-lg-3">
                    <div class="card product-card border-0 shadow-sm h-100">
                        @if($product->preview_image)
                            <img src="{{ $product->preview_image_url }}" class="card-img-top" alt="{{ $product->title }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <span class="badge bg-primary rounded-pill mb-2">{{ $product->category->name }}</span>
                            <h6 class="fw-bold mb-2">{{ Str::limit($product->title, 40) }}</h6>
                            <p class="text-muted small mb-3">{{ Str::limit($product->description, 60) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-primary mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-white border-top-0">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary w-100">
                                <i class="bi bi-eye me-2"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle me-2"></i>Belum ada produk tersedia
                    </div>
                </div>
            @endforelse
        </div>
        
        @if($featuredProducts->count() > 0)
            <div class="text-center mt-5">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-5">
                    <i class="bi bi-grid me-2"></i>Lihat Semua Produk
                </a>
            </div>
        @endif
    </div>
</section>

{{-- Categories Section --}}
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">Kategori Produk</h2>
            <p class="text-muted">Temukan template sesuai kebutuhan Anda</p>
        </div>
        
        <div class="row g-4">
            @foreach($categories as $category)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route('products.index', ['category' => $category->id]) }}" class="text-decoration-none">
                        <div class="card category-card border-0 shadow-sm text-center h-100">
                            <div class="card-body py-4">
                                @if($category->icon)
                                    <i class="bi bi-{{ $category->icon }} text-primary" style="font-size: 2.5rem;"></i>
                                @else
                                    <i class="bi bi-folder text-primary" style="font-size: 2.5rem;"></i>
                                @endif
                                <h6 class="fw-bold mt-3 mb-1">{{ $category->name }}</h6>
                                <small class="text-muted">{{ $category->products_count }} produk</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-5 gradient-bg text-white">
    <div class="container py-5">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold mb-4">
                    Siap Memulai Desain Digital Anda?
                </h2>
                <p class="lead mb-5">
                    Daftar sekarang dan dapatkan akses ke ratusan template digital profesional
                </p>
                <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5">
                    <i class="bi bi-person-plus me-2"></i>Daftar Gratis
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
