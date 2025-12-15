@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="container py-4">
    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1 display-6 ls-tight">
                Pesanan Saya
            </h2>
            <p class="text-muted mb-0">Kelola dan pantau riwayat pembelian aset digital Anda.</p>
        </div>
        <div>
            <a href="{{ route('products.index') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-plus-lg me-2"></i>Order Baru
            </a>
        </div>
    </div>

    {{-- Orders List --}}
    @forelse($orders as $order)
        <div class="card border-0 shadow-sm rounded-3 mb-3 hover-shadow transition-all">
            <div class="card-body p-4">
                <div class="row g-4 align-items-center">
                    {{-- Product Image --}}
                    <div class="col-12 col-sm-auto">
                        <div class="position-relative">
                            @if($order->product->preview_image)
                                <img src="{{ $order->product->preview_image_url }}" 
                                     class="rounded-3 shadow-sm" 
                                     style="width: 100px; height: 100px; object-fit: cover;"
                                     alt="{{ $order->product->title }}">
                            @else
                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center shadow-sm" 
                                     style="width: 100px; height: 100px;">
                                    <i class="bi bi-image text-muted fs-2"></i>
                                </div>
                            @endif
                            <div class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-white text-dark shadow-sm border" style="font-size: 0.7rem; display: {{ $order->product->preview_image ? 'block' : 'none' }}">
                                {{ $order->product->category->name }}
                            </div>
                        </div>
                    </div>

                    {{-- Main Info Stack --}}
                    <div class="col-12 col-sm">
                        <div class="d-flex flex-column gap-1">
                            {{-- Order Code --}}
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-light text-secondary border fw-normal text-uppercase letter-spacing-1">
                                    #{{ $order->order_code }}
                                </span>
                                <span class="text-muted small">
                                    <i class="bi bi-clock me-1"></i>{{ $order->created_at->format('d M Y, H:i') }}
                                </span>
                            </div>

                            {{-- Title --}}
                            <h5 class="fw-bold text-dark mb-0">
                                <a href="{{ route('user.orders.show', $order) }}" class="text-decoration-none text-dark stretched-link">
                                    {{ $order->product->title }}
                                </a>
                            </h5>
                            
                            {{-- Category (Mobile Only if needed, but included in layout) --}}
                            <div class="text-muted small mt-1 d-sm-none">
                                {{ $order->product->category->name }}
                            </div>

                             {{-- Price --}}
                             <div class="mt-2">
                                <span class="text-muted small me-1">Total:</span>
                                <span class="fw-bold text-primary fs-5">
                                    Rp {{ number_format($order->amount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Status Badge --}}
                    <div class="col-auto">
                        @php
                            $statusClass = match($order->status) {
                                'paid' => 'success',
                                'pending' => 'warning',
                                'waiting_verification' => 'info',
                                'approved' => 'info',
                                'in_progress' => 'primary',
                                'revision' => 'warning',
                                'completed' => 'success',
                                'rejected' => 'danger',
                                default => 'secondary',
                            };
                            $statusLabel = match($order->status) {
                                'paid' => 'Lunas',
                                'pending' => 'Pending',
                                'waiting_verification' => 'Verifikasi',
                                'approved' => 'Approved',
                                'in_progress' => 'Proses Desain',
                                'revision' => 'Revisi',
                                'completed' => 'Selesai',
                                'rejected' => 'Ditolak',
                                default => ucfirst($order->status),
                            };
                            $statusIcon = match($order->status) {
                                'paid' => 'check-circle-fill',
                                'pending' => 'clock-fill',
                                'waiting_verification' => 'hourglass-split',
                                'approved' => 'check-circle-fill',
                                'in_progress' => 'hourglass-split',
                                'revision' => 'arrow-repeat',
                                'completed' => 'check-all',
                                'rejected' => 'x-circle-fill',
                                default => 'question-circle-fill',
                            };
                        @endphp
                        <div class="d-flex flex-column align-items-end gap-2">
                            <span class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }} rounded-pill px-3 py-2 d-flex align-items-center gap-2 border border-{{ $statusClass }}-subtle">
                                <i class="bi bi-{{ $statusIcon }}"></i>
                                {{ $statusLabel }}
                            </span>
                        </div>
                    </div>

                    {{-- Action Button --}}
                    <div class="col-12 col-md-auto border-start-md ps-md-4 text-end text-md-center">
                        <a href="{{ route('user.orders.show', $order) }}" class="btn btn-outline-primary rounded-pill px-4 w-100 w-md-auto position-relative" style="z-index: 2;">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm rounded-4 py-5 text-center">
            <div class="card-body">
                <div class="mb-3">
                    <div class="bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px;">
                        <i class="bi bi-bag fs-1"></i>
                    </div>
                </div>
                <h4 class="fw-bold">Belum Ada Pesanan</h4>
                <p class="text-muted mb-4">Anda belum melakukan pembelian aset digital apapun.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary rounded-pill px-4">
                    Mulai Belanja
                </a>
            </div>
        </div>
    @endforelse

    {{-- Pagination --}}
    @if($orders->hasPages())
        <div class="mt-5">
            {{ $orders->links() }}
        </div>
    @endif
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
    .border-start-md {
        border-left: 0;
    }
    @media (min-width: 768px) {
        .border-start-md {
            border-left: 1px solid #dee2e6;
        }
    }
</style>
@endsection
