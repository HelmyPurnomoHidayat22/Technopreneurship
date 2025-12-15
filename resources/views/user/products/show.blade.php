@extends('layouts.app')

@section('title', $product->title)

@section('content')
{{-- Back Button --}}
<div class="mb-3">
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Katalog
    </a>
</div>

<div class="row g-4">
    {{-- Product Image --}}
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                @if($product->preview_image)
                    <img src="{{ $product->preview_image_url }}" 
                         class="img-fluid w-100 rounded-top" 
                         alt="{{ $product->title }}" 
                         style="max-height: 500px; object-fit: cover;">
                @else
                    <div class="d-flex align-items-center justify-content-center" 
                         style="height: 500px; background: linear-gradient(135deg, #5B6CFF 0%, #6A82FB 100%); border-radius: 12px 12px 0 0;">
                        <i class="bi bi-image fs-1 text-white opacity-50"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    {{-- Product Details --}}
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                {{-- Category Badge --}}
                <div class="mb-3">
                    <span class="badge bg-primary rounded-pill fs-6">{{ $product->category->name }}</span>
                </div>
                
                {{-- Title --}}
                <h1 class="display-6 fw-bold mb-3">{{ $product->title }}</h1>
                
                {{-- Price --}}
                <div class="mb-4 pb-4 border-bottom">
                    <span class="text-muted d-block mb-2">Harga</span>
                    <span class="display-5 fw-bold text-primary">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                </div>
                
                {{-- Description --}}
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-info-circle me-2 text-primary"></i>Deskripsi Produk
                    </h5>
                    <p class="text-muted mb-0" style="line-height: 1.8; font-size: 1.05rem;">
                        {{ $product->description }}
                    </p>
                </div>
                
                {{-- CTA Buttons --}}
                <div class="d-grid gap-2 mt-4">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login untuk Membeli
                        </a>
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            <small>Silakan login atau daftar terlebih dahulu untuk melakukan pembelian</small>
                        </div>
                    @else
                        <a href="{{ route('checkout.create', $product) }}" class="btn btn-primary btn-lg fw-semibold">
                            <i class="bi bi-cart-plus-fill me-2"></i>Beli Sekarang
                        </a>
                    @endguest
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Lanjut Berbelanja
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
