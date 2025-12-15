@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

@section('content')
{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-graph-up me-2 text-primary"></i>Laporan Penjualan
        </h2>
        <p class="text-muted mb-0">Analisis dan statistik penjualan produk</p>
    </div>
</div>

{{-- Statistics Cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="stat-card text-white" style="background: linear-gradient(135deg, #5B6CFF 0%, #6A82FB 100%);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="text-white-50 mb-2">Total Transaksi</h5>
                    <h2 class="mb-0 fw-bold">{{ $totalTransactions }}</h2>
                    <small class="text-white-50">Pesanan berhasil</small>
                </div>
                <i class="bi bi-receipt-cutoff fs-1 opacity-25"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="stat-card text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="text-white-50 mb-2">Total Pendapatan</h5>
                    <h2 class="mb-0 fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                    <small class="text-white-50">Dari semua penjualan</small>
                </div>
                <i class="bi bi-currency-dollar fs-1 opacity-25"></i>
            </div>
        </div>
    </div>
</div>

{{-- Best Selling Products --}}
<div class="card shadow-sm border-0 mb-4">
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
                            <th class="ps-4">Produk</th>
                            <th class="text-center">Total Pesanan</th>
                            <th class="text-end pe-4">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bestSellingProducts as $product)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($product->preview_image)
                                            <img src="{{ $product->preview_image_url }}" 
                                                 alt="{{ $product->title }}" 
                                                 class="rounded me-3" 
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 60px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong class="d-block">{{ $product->title }}</strong>
                                            <small class="text-muted">{{ $product->category->name }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary rounded-pill fs-6 px-3">{{ $product->total_orders }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <strong class="text-success fs-5">Rp {{ number_format($product->total_revenue ?? 0, 0, ',', '.') }}</strong>
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

{{-- Sales by Status --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-pie-chart me-2 text-primary"></i>Penjualan per Status
        </h5>
    </div>
    <div class="card-body">
        @if($salesByStatus->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4">Status</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end pe-4">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salesByStatus as $status)
                            <tr>
                                <td class="ps-4">
                                    @if($status->status == 'pending')
                                        <span class="badge bg-secondary rounded-pill">
                                            <i class="bi bi-clock me-1"></i>Pending
                                        </span>
                                    @elseif($status->status == 'waiting_verification')
                                        <span class="badge bg-warning rounded-pill">
                                            <i class="bi bi-hourglass-split me-1"></i>Menunggu Verifikasi
                                        </span>
                                    @elseif($status->status == 'paid')
                                        <span class="badge bg-success rounded-pill">
                                            <i class="bi bi-check-circle me-1"></i>Lunas
                                        </span>
                                    @elseif($status->status == 'approved')
                                        <span class="badge bg-info rounded-pill">
                                            <i class="bi bi-check-circle me-1"></i>Approved
                                        </span>
                                    @elseif($status->status == 'in_progress')
                                        <span class="badge bg-primary rounded-pill">
                                            <i class="bi bi-hourglass-split me-1"></i>In Progress
                                        </span>
                                    @elseif($status->status == 'revision')
                                        <span class="badge bg-warning rounded-pill">
                                            <i class="bi bi-arrow-repeat me-1"></i>Revisi
                                        </span>
                                    @elseif($status->status == 'completed')
                                        <span class="badge bg-success rounded-pill">
                                            <i class="bi bi-check-all me-1"></i>Selesai
                                        </span>
                                    @elseif($status->status == 'rejected')
                                        <span class="badge bg-danger rounded-pill">
                                            <i class="bi bi-x-circle me-1"></i>Ditolak
                                        </span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill">
                                            {{ ucfirst($status->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <strong>{{ $status->count }}</strong>
                                </td>
                                <td class="text-end pe-4">
                                    <strong class="text-primary">Rp {{ number_format($status->total ?? 0, 0, ',', '.') }}</strong>
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
@endsection
