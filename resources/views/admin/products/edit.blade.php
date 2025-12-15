@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-pencil me-2 text-primary"></i>Edit Produk
        </h2>
        <p class="text-muted mb-0">Perbarui informasi produk</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-info-circle me-2 text-primary"></i>Informasi Produk
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-4">
                        {{-- Title & Category --}}
                        <div class="col-md-8">
                            <label for="title" class="form-label fw-semibold">
                                Judul Produk <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $product->title) }}" 
                                   placeholder="Contoh: Professional Business Presentation Template" 
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="category_id" class="form-label fw-semibold">
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" 
                                    name="category_id" 
                                    required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- Description --}}
                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold">
                                Deskripsi Produk <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="5" 
                                      placeholder="Jelaskan produk secara detail..." 
                                      required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- Price --}}
                        <div class="col-md-6">
                            <label for="price" class="form-label fw-semibold">
                                Harga (Rp) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">Rp</span>
                                <input type="number" 
                                       step="0.01" 
                                       min="0" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       id="price" 
                                       name="price" 
                                       value="{{ old('price', $product->price) }}" 
                                       placeholder="99000" 
                                       required>
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- Preview Image --}}
                        <div class="col-md-6">
                            <label for="preview_image" class="form-label fw-semibold">
                                Preview Image
                            </label>
                            <input type="file" 
                                   class="form-control @error('preview_image') is-invalid @enderror" 
                                   id="preview_image" 
                                   name="preview_image" 
                                   accept="image/*" 
                                   onchange="previewImage(this)">
                            <small class="text-muted">Biarkan kosong untuk menggunakan gambar saat ini</small>
                            @if($product->preview_image)
                                <div class="mt-2">
                                    <small class="text-muted d-block mb-2">Gambar saat ini:</small>
                                    <img src="{{ $product->preview_image_url }}" 
                                         class="img-thumbnail shadow-sm" 
                                         style="max-width: 150px;" 
                                         alt="Current preview">
                                </div>
                            @endif
                            <div id="imagePreview" class="mt-3"></div>
                            @error('preview_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- Product File --}}
                        <div class="col-12">
                            <label for="file_template" class="form-label fw-semibold">
                                File Produk
                            </label>
                            <input type="file" 
                                   class="form-control @error('file_template') is-invalid @enderror" 
                                   id="file_template" 
                                   name="file_template" 
                                   accept=".pptx,.pdf,.psd,.zip,.ai,.eps,.docx,.xlsx,.fig,.sketch">
                            <small class="text-muted">Biarkan kosong untuk menggunakan file saat ini</small>
                            @error('file_template')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    {{-- Action Buttons --}}
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Update Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <div class="border rounded p-2 bg-light" style="max-width: 300px;">
                    <small class="text-muted d-block mb-2">Preview baru:</small>
                    <img src="${e.target.result}" class="img-fluid rounded shadow-sm" alt="Preview">
                </div>
            `;
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.innerHTML = '';
    }
}
</script>
@endpush
@endsection
