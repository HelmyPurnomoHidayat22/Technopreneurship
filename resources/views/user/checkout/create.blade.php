@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
{{-- Back Button --}}
<div class="mb-3">
    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Detail Produk
    </a>
</div>

<div class="row g-4">
    {{-- Checkout Form --}}
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom">
                <h4 class="mb-0 fw-bold">
                    <i class="bi bi-cart-check me-2 text-primary"></i>Informasi Checkout
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('checkout.store', $product) }}" method="POST">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="customer_name" class="form-label fw-semibold">
                                <i class="bi bi-person me-1"></i>Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('customer_name') is-invalid @enderror" 
                                   id="customer_name" 
                                   name="customer_name" 
                                   value="{{ old('customer_name', auth()->user()->name) }}" 
                                   required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="customer_email" class="form-label fw-semibold">
                                <i class="bi bi-envelope me-1"></i>Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control @error('customer_email') is-invalid @enderror" 
                                   id="customer_email" 
                                   name="customer_email" 
                                   value="{{ old('customer_email', auth()->user()->email) }}" 
                                   required>
                            @error('customer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="customer_phone" class="form-label fw-semibold">
                                <i class="bi bi-telephone me-1"></i>No. Telepon <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('customer_phone') is-invalid @enderror" 
                                   id="customer_phone" 
                                   name="customer_phone" 
                                   value="{{ old('customer_phone') }}" 
                                   placeholder="08xxxxxxxxxx" 
                                   required>
                            @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- Custom Design Section (Conditional) --}}
                    @if($product->category && $product->category->name === 'Custom Design')
                        <hr class="my-4">
                        
                        <div class="mb-3">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-palette me-2 text-primary"></i>Detail Custom Design
                            </h5>
                            <p class="text-muted small">Bantu kami memahami kebutuhan desain Anda</p>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="custom_category" class="form-label fw-semibold">
                                    <i class="bi bi-tag me-1"></i>Kategori Desain <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('custom_category') is-invalid @enderror" 
                                        id="custom_category" 
                                        name="custom_category" 
                                        required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="PPT" {{ old('custom_category') == 'PPT' ? 'selected' : '' }}>PPT (Presentasi)</option>
                                    <option value="CV" {{ old('custom_category') == 'CV' ? 'selected' : '' }}>CV (Curriculum Vitae)</option>
                                    <option value="Undangan" {{ old('custom_category') == 'Undangan' ? 'selected' : '' }}>Undangan</option>
                                    <option value="Notion" {{ old('custom_category') == 'Notion' ? 'selected' : '' }}>Notion Template</option>
                                    <option value="Canva Template" {{ old('custom_category') == 'Canva Template' ? 'selected' : '' }}>Canva Template</option>
                                    <option value="Social Media Kit" {{ old('custom_category') == 'Social Media Kit' ? 'selected' : '' }}>Social Media Kit</option>
                                    <option value="Logo Design" {{ old('custom_category') == 'Logo Design' ? 'selected' : '' }}>Logo Design</option>
                                    <option value="Icon Pack" {{ old('custom_category') == 'Icon Pack' ? 'selected' : '' }}>Icon Pack</option>
                                    <option value="Video Template" {{ old('custom_category') == 'Video Template' ? 'selected' : '' }}>Video Template</option>
                                    <option value="Font Pack" {{ old('custom_category') == 'Font Pack' ? 'selected' : '' }}>Font Pack</option>
                                    <option value="Mockup" {{ old('custom_category') == 'Mockup' ? 'selected' : '' }}>Mockup</option>
                                    <option value="Lainnya" {{ old('custom_category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('custom_category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="custom_notes" class="form-label fw-semibold">
                                    <i class="bi bi-pencil me-1"></i>Catatan untuk Desainer
                                </label>
                                <textarea class="form-control @error('custom_notes') is-invalid @enderror" 
                                          id="custom_notes" 
                                          name="custom_notes" 
                                          rows="5" 
                                          maxlength="1000"
                                          placeholder="Contoh: Warna dominan biru, gaya minimalis, target mahasiswa, ukuran A4, format PDF dan editable, deadline 3 hari...">{{ old('custom_notes') }}</textarea>
                                @error('custom_notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Semakin detail catatan Anda, semakin sesuai hasil desain dengan harapan. Maksimal 1000 karakter.
                                </small>
                            </div>

                            <div class="col-md-6">
                                <label for="custom_deadline" class="form-label fw-semibold">
                                    <i class="bi bi-calendar me-1"></i>Deadline (Opsional)
                                </label>
                                <input type="date" 
                                       class="form-control @error('custom_deadline') is-invalid @enderror" 
                                       id="custom_deadline" 
                                       name="custom_deadline" 
                                       value="{{ old('custom_deadline') }}"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                @error('custom_deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Kapan Anda membutuhkan desain ini?</small>
                            </div>

                            <div class="col-md-6">
                                <label for="custom_reference_link" class="form-label fw-semibold">
                                    <i class="bi bi-link-45deg me-1"></i>Link Referensi (Opsional)
                                </label>
                                <input type="url" 
                                       class="form-control @error('custom_reference_link') is-invalid @enderror" 
                                       id="custom_reference_link" 
                                       name="custom_reference_link" 
                                       value="{{ old('custom_reference_link') }}"
                                       placeholder="https://example.com/referensi">
                                @error('custom_reference_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Link ke desain yang Anda suka atau referensi lainnya</small>
                            </div>
                        </div>
                    @endif
                    
                    <hr class="my-4">
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                            <i class="bi bi-check-circle me-2"></i>Lanjutkan Checkout
                        </button>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    {{-- Order Summary --}}
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 sticky-top" style="top: 100px;">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold">Ringkasan Pesanan</h5>
            </div>
            <div class="card-body">
                {{-- Product Info --}}
                <div class="d-flex align-items-center mb-4 pb-4 border-bottom">
                    @if($product->preview_image)
                        <img src="{{ $product->preview_image_url }}" 
                             class="rounded me-3" 
                             style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-image text-muted"></i>
                        </div>
                    @endif
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">{{ Str::limit($product->title, 40) }}</h6>
                        <small class="text-muted">{{ $product->category->name }}</small>
                    </div>
                </div>
                
                {{-- Price Summary --}}
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Biaya Admin</span>
                        <span class="fw-semibold text-success">Rp 0</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Total</span>
                        <span class="h5 fw-bold text-primary mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                {{-- Payment Info --}}
                <div class="alert alert-info mb-0">
                    <h6 class="fw-bold mb-2">
                        <i class="bi bi-info-circle me-2"></i>Cara Pembayaran
                    </h6>
                    <p class="mb-2 small">Setelah checkout, Anda akan mendapatkan kode pesanan. Silakan transfer ke:</p>
                    <ul class="mb-0 small">
                        <li><strong>Bank:</strong> BCA / Mandiri / BRI</li>
                        <li><strong>Rekening:</strong> 1234567890</li>
                        <li><strong>Atas Nama:</strong> DigitalCreativeHub</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
