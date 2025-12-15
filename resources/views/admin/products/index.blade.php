@extends('layouts.admin')

@section('title', 'Kelola Produk')

@section('content')
{{-- Page Header --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-box-seam me-2 text-primary"></i>Kelola Produk
        </h2>
        <p class="text-muted mb-0">Tambah, edit, dan kelola produk digital Anda</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Produk
    </a>
</div>

{{-- Products Table --}}
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px;" class="ps-4">ID</th>
                        <th>Produk</th>
                        <th style="width: 150px;">Kategori</th>
                        <th style="width: 150px;" class="text-end pe-4">Harga</th>
                        <th style="width: 200px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td class="ps-4">
                                <span class="text-muted fw-semibold">#{{ $product->id }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($product->preview_image)
                                        <img src="{{ $product->preview_image_url }}" 
                                             alt="{{ $product->title }}" 
                                             class="rounded me-3 shadow-sm" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center shadow-sm" 
                                             style="width: 60px; height: 60px;">
                                            <i class="bi bi-image text-muted fs-4"></i>
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold mb-1">{{ $product->title }}</div>
                                        <small class="text-muted">{{ Str::limit($product->description, 60) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary rounded-pill">{{ $product->category->name }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <strong class="text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.products.show', $product) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="btn btn-sm btn-warning" 
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" 
                                          method="POST" 
                                          class="d-inline" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-5">
                                    <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                                    <h5 class="text-muted mb-2">Belum ada produk</h5>
                                    <p class="text-muted mb-3">Mulai dengan menambahkan produk pertama Anda</p>
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i>Tambah Produk Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- Pagination --}}
    @if($products->hasPages())
        <div class="card-footer bg-white border-top">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div class="pagination-info text-center text-md-start mb-0">
                    Menampilkan <strong>{{ $products->firstItem() }}</strong> sampai <strong>{{ $products->lastItem() }}</strong> dari <strong>{{ $products->total() }}</strong> produk
                </div>
                <nav aria-label="Product pagination" class="d-flex justify-content-center">
                    {{ $products->links() }}
                </nav>
            </div>
        </div>
    @endif
</div>

{{-- Responsive Table Styles --}}
<style>
@media (max-width: 768px) {
    .table th:nth-child(2),
    .table td:nth-child(2) {
        min-width: 200px;
    }
}
</style>
@endsection
