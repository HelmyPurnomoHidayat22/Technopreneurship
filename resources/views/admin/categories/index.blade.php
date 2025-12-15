@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')
<div class="container-fluid py-4">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-tags me-2 text-primary"></i>Kelola Kategori
            </h2>
            <p class="text-muted mb-0">Customisasi tampilan dan informasi kategori</p>
        </div>
    </div>

    {{-- Categories List --}}
    <div class="row">
        @forelse($categories as $category)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold mb-1">
                                    @if($category->icon)
                                        <i class="bi bi-{{ $category->icon }} me-2"></i>
                                    @endif
                                    {{ $category->name }}
                                </h5>
                                <span class="badge {{ $category->custom_style ?? 'bg-secondary' }} rounded-pill">
                                    {{ $category->products_count }} Produk
                                </span>
                            </div>
                        </div>

                        @if($category->note)
                            <p class="text-muted small mb-3">{{ Str::limit($category->note, 100) }}</p>
                        @else
                            <p class="text-muted small fst-italic mb-3">Belum ada catatan</p>
                        @endif

                        <a href="{{ route('admin.categories.customize', $category) }}" class="btn btn-sm btn-outline-primary w-100">
                            <i class="bi bi-gear me-2"></i>Customisasi
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>Belum ada kategori
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
