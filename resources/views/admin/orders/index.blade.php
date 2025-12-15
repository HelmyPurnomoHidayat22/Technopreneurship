@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

@section('content')
{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-receipt me-2 text-primary"></i>Kelola Pesanan
        </h2>
        <p class="text-muted mb-0">Verifikasi dan kelola semua pesanan pelanggan</p>
    </div>
</div>

{{-- Orders Table --}}
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">Kode Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Produk</th>
                        <th class="text-end">Jumlah</th>
                        <th class="text-center">Status</th>
                        <th>Tanggal</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="ps-4">
                                <code class="bg-light px-2 py-1 rounded">{{ $order->order_code }}</code>
                            </td>
                            <td>
                                <div>
                                    <strong class="d-block">{{ $order->customer_name }}</strong>
                                    <small class="text-muted">{{ $order->customer_email }}</small>
                                </div>
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
                                <strong class="text-primary">Rp {{ number_format($order->amount, 0, ',', '.') }}</strong>
                            </td>
                            <td class="text-center">
                                @if($order->status == 'pending')
                                    <span class="badge bg-secondary rounded-pill">Pending</span>
                                @elseif($order->status == 'waiting_verification')
                                    <span class="badge bg-warning rounded-pill">
                                        <i class="bi bi-clock me-1"></i>Menunggu Verifikasi
                                    </span>
                                @elseif($order->status == 'paid')
                                    <span class="badge bg-success rounded-pill">
                                        <i class="bi bi-check-circle me-1"></i>Lunas
                                    </span>
                                @elseif($order->status == 'approved')
                                    <span class="badge bg-info rounded-pill">
                                        <i class="bi bi-check-circle me-1"></i>Approved
                                    </span>
                                @elseif($order->status == 'in_progress')
                                    <span class="badge bg-primary rounded-pill">
                                        <i class="bi bi-hourglass-split me-1"></i>In Progress
                                    </span>
                                @elseif($order->status == 'revision')
                                    <span class="badge bg-warning rounded-pill">
                                        <i class="bi bi-arrow-repeat me-1"></i>Revision
                                    </span>
                                @elseif($order->status == 'completed')
                                    <span class="badge bg-success rounded-pill">
                                        <i class="bi bi-check-all me-1"></i>Completed
                                    </span>
                                @elseif($order->status == 'rejected')
                                    <span class="badge bg-danger rounded-pill">
                                        <i class="bi bi-x-circle me-1"></i>Ditolak
                                    </span>
                                @else
                                    <span class="badge bg-secondary rounded-pill">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                            </td>
                            <td class="text-center pe-4">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                                <h5 class="text-muted mb-0">Belum ada pesanan</h5>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- Pagination --}}
    @if($orders->hasPages())
        <div class="card-footer bg-white border-top">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div class="pagination-info text-center text-md-start mb-0">
                    Menampilkan <strong>{{ $orders->firstItem() }}</strong> sampai <strong>{{ $orders->lastItem() }}</strong> dari <strong>{{ $orders->total() }}</strong> pesanan
                </div>
                <nav aria-label="Orders pagination" class="d-flex justify-content-center">
                    {{ $orders->links() }}
                </nav>
            </div>
        </div>
    @endif
</div>
@endsection
