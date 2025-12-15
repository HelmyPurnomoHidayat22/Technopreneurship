@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Dashboard</h2>
        <p class="text-muted mb-0">Ringkasan aktivitas dan statistik penjualan</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Produk
    </a>
</div>

{{-- Statistics Cards --}}
<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card text-white" style="background: linear-gradient(135deg, #5B6CFF 0%, #6A82FB 100%);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="text-white-50 mb-2">Total Users</h5>
                    <h2 class="mb-0 fw-bold">{{ $totalUsers }}</h2>
                    <small class="text-white-50">Pelanggan terdaftar</small>
                </div>
                <i class="bi bi-people-fill fs-1 opacity-25"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="text-white-50 mb-2">Total Transaksi</h5>
                    <h2 class="mb-0 fw-bold">{{ $totalTransactions }}</h2>
                    <small class="text-white-50">Semua pesanan</small>
                </div>
                <i class="bi bi-receipt-cutoff fs-1 opacity-25"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="text-white-50 mb-2">Total Pendapatan</h5>
                    <h2 class="mb-0 fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                    <small class="text-white-50">Dari pesanan berhasil</small>
                </div>
                <i class="bi bi-currency-dollar fs-1 opacity-25"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card text-white" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="text-white-50 mb-2">Produk Terlaris</h5>
                    <h2 class="mb-0 fw-bold">{{ $bestSellingProducts->count() }}</h2>
                    <small class="text-white-50">Produk dengan penjualan</small>
                </div>
                <i class="bi bi-trophy-fill fs-1 opacity-25"></i>
            </div>
        </div>
    </div>
</div>

{{-- Best Selling Products --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white border-bottom">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-trophy-fill text-warning me-2"></i>Produk Terlaris
        </h5>
    </div>
    <div class="card-body">
        @if($bestSellingProducts->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Total Pesanan</th>
                            <th class="text-end">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bestSellingProducts as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($product->preview_image)
                                            <img src="{{ $product->preview_image_url }}" 
                                                 alt="{{ $product->title }}" 
                                                 class="rounded me-3" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $product->title }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $product->category->name }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary rounded-pill">{{ $product->total_orders }}</span>
                                </td>
                                <td class="text-end">
                                    <strong class="text-success">Rp {{ number_format($product->total_revenue ?? 0, 0, ',', '.') }}</strong>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                <p class="text-muted mb-0">Belum ada data penjualan</p>
            </div>
        @endif
    </div>
</div>

{{-- Quick Actions --}}
<div class="row g-3">
    <div class="col-md-4">
        <a href="{{ route('admin.products.index') }}" class="card text-decoration-none shadow-sm h-100 border-0">
            <div class="card-body text-center">
                <i class="bi bi-box-seam fs-1 text-primary mb-3"></i>
                <h5 class="fw-bold">Kelola Produk</h5>
                <p class="text-muted small mb-0">Tambah, edit, atau hapus produk</p>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.orders.index') }}" class="card text-decoration-none shadow-sm h-100 border-0">
            <div class="card-body text-center">
                <i class="bi bi-receipt fs-1 text-info mb-3"></i>
                <h5 class="fw-bold">Verifikasi Pesanan</h5>
                <p class="text-muted small mb-0">Verifikasi pembayaran manual</p>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.reports.index') }}" class="card text-decoration-none shadow-sm h-100 border-0">
            <div class="card-body text-center">
                <i class="bi bi-graph-up fs-1 text-success mb-3"></i>
                <h5 class="fw-bold">Laporan Penjualan</h5>
                <p class="text-muted small mb-0">Lihat statistik dan laporan</p>
            </div>
        </a>
    </div>
</div>
@endsection
