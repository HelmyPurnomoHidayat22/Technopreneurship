@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')
{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-person me-2 text-primary"></i>Detail User
        </h2>
        <p class="text-muted mb-0">{{ $user->name }}</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row g-4">
    {{-- User Info --}}
    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-info-circle me-2 text-primary"></i>Informasi User
                </h5>
            </div>
            <div class="card-body text-center">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 80px; height: 80px; font-size: 2rem;">
                    <i class="bi bi-person"></i>
                </div>
                <h4 class="fw-bold mb-2">{{ $user->name }}</h4>
                <p class="text-muted mb-3">{{ $user->email }}</p>
                <div class="d-grid">
                    <span class="badge bg-secondary rounded-pill fs-6 py-2">
                        <i class="bi bi-person-check me-1"></i>User
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Order History --}}
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-receipt me-2 text-primary"></i>Riwayat Pesanan
                    <span class="badge bg-primary ms-2">{{ $user->orders->count() }}</span>
                </h5>
            </div>
            <div class="card-body p-0">
                @if($user->orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th class="ps-4">Kode Pesanan</th>
                                    <th>Produk</th>
                                    <th class="text-end">Jumlah</th>
                                    <th class="text-center">Status</th>
                                    <th class="pe-4">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->orders as $order)
                                    <tr>
                                        <td class="ps-4">
                                            <code class="bg-light px-2 py-1 rounded small">{{ $order->order_code }}</code>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($order->product->preview_image)
                                                    <img src="{{ $order->product->preview_image_url }}" 
                                                         class="rounded me-2" 
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @endif
                                                <span>{{ Str::limit($order->product->title, 30) }}</span>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <strong>Rp {{ number_format($order->amount, 0, ',', '.') }}</strong>
                                        </td>
                                        <td class="text-center">
                                            @if($order->status == 'pending')
                                                <span class="badge bg-secondary rounded-pill">Pending</span>
                                            @elseif($order->status == 'waiting_verification')
                                                <span class="badge bg-warning rounded-pill">Menunggu Verifikasi</span>
                                            @elseif($order->status == 'paid')
                                                <span class="badge bg-success rounded-pill">Lunas</span>
                                            @else
                                                <span class="badge bg-danger rounded-pill">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="pe-4">
                                            <small class="text-muted">{{ $order->created_at->format('d M Y') }}</small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                        <p class="text-muted mb-0">User ini belum pernah melakukan pesanan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
