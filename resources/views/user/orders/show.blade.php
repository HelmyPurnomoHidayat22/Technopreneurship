@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
{{-- Back Button --}}
<div class="mb-3">
    <a href="{{ route('user.orders.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Pesanan
    </a>
</div>

<div class="row g-4">
    {{-- Order Information --}}
    <div class="col-lg-8">
        {{-- Order Summary --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-info-circle me-2 text-primary"></i>Informasi Pesanan
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="text-muted small">Kode Pesanan</label>
                        <p class="fw-bold mb-0">
                            <code class="bg-light px-2 py-1 rounded">{{ $order->order_code }}</code>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Tanggal Pesanan</label>
                        <p class="fw-semibold mb-0">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                {{-- Product Info --}}
                <div class="border rounded p-3 bg-light">
                    <div class="d-flex align-items-center">
                        @if($order->product->preview_image)
                            <img src="{{ $order->product->preview_image_url }}" 
                                 class="rounded me-3" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <div class="bg-white rounded me-3 d-flex align-items-center justify-content-center" 
                                 style="width: 100px; height: 100px;">
                                <i class="bi bi-image text-muted fs-3"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <h5 class="fw-bold mb-2">{{ $order->product->title }}</h5>
                            <p class="text-muted mb-2">
                                <span class="badge bg-primary">{{ $order->product->category->name }}</span>
                            </p>
                            <h4 class="text-primary mb-0">Rp {{ number_format($order->amount, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Rejection Notice (if rejected) --}}
        @if($order->status === 'rejected' && $order->rejection_note)
            <div class="card shadow-sm border-danger rounded-3 mb-4">
                <div class="card-header bg-danger bg-opacity-10 border-danger">
                    <h5 class="mb-0 fw-bold text-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>Pesanan Ditolak
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger mb-3">
                        <p class="mb-2">
                            <strong>Mohon maaf, pesanan Anda tidak dapat kami proses karena:</strong>
                        </p>
                        <div class="bg-white rounded p-3 border border-danger border-opacity-25">
                            <p class="mb-0" style="white-space: pre-wrap;">{{ $order->rejection_note }}</p>
                        </div>
                    </div>
                    
                    @if($order->rejected_at)
                        <p class="text-muted small mb-3">
                            <i class="bi bi-clock me-1"></i>
                            Ditolak pada: {{ $order->rejected_at->format('d M Y, H:i') }}
                        </p>
                    @endif

                    <div class="bg-light rounded p-3">
                        <p class="mb-2">
                            <i class="bi bi-info-circle me-2 text-primary"></i>
                            <strong>Apa yang bisa Anda lakukan?</strong>
                        </p>
                        <ul class="mb-2 small">
                            <li>
                                Hubungi kami untuk klarifikasi lebih lanjut
                                <br>
                                <i class="bi bi-envelope me-1"></i>
                                <a href="mailto:helmypurnomo234@gmail.com" class="text-decoration-none">
                                    helmypurnomo234@gmail.com
                                </a>
                            </li>
                            <li>Perbaiki pesanan sesuai catatan di atas</li>
                            <li>Buat pesanan baru dengan informasi yang lebih lengkap</li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Payment Instructions --}}
        @if($order->status == 'pending')
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-credit-card me-2 text-primary"></i>Cara Pembayaran
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-0">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-info-circle me-2"></i>Instruksi Pembayaran
                        </h6>
                        <p class="mb-3">Silakan transfer pembayaran ke rekening berikut:</p>
                        <div class="bg-white rounded p-3 mb-3">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <strong>Bank:</strong> BCA / Mandiri / BRI
                                </div>
                                <div class="col-md-6">
                                    <strong>No. Rekening:</strong> <code>1234567890</code>
                                </div>
                                <div class="col-md-6">
                                    <strong>Atas Nama:</strong> DigitalCreativeHub
                                </div>
                                <div class="col-md-6">
                                    <strong>Jumlah:</strong> 
                                    <span class="text-primary fw-bold">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <p class="mb-0 small">
                            <i class="bi bi-exclamation-circle me-1"></i>
                            Setelah transfer, silakan upload bukti pembayaran di bawah ini.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Custom Design Details (if applicable) --}}
            @if($order->custom_category || $order->custom_notes)
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-palette me-2 text-primary"></i>Detail Custom Design
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($order->custom_category)
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted small">Kategori Desain</label>
                                <p class="mb-0">
                                    <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                        <i class="bi bi-tag me-1"></i>{{ $order->custom_category }}
                                    </span>
                                </p>
                            </div>
                        @endif

                        @if($order->custom_notes)
                            <div>
                                <label class="form-label fw-semibold text-muted small">Catatan untuk Desainer</label>
                                <div class="bg-light rounded p-3">
                                    <p class="mb-0" style="white-space: pre-wrap;">{{ $order->custom_notes }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Upload Payment Proof --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-cloud-upload me-2 text-primary"></i>Upload Bukti Pembayaran
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.orders.upload-payment', $order) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="payment_proof" class="form-label fw-semibold">
                                Upload File Bukti Pembayaran <span class="text-danger">*</span>
                            </label>
                            <input type="file" 
                                   class="form-control @error('payment_proof') is-invalid @enderror" 
                                   id="payment_proof" 
                                   name="payment_proof" 
                                   accept=".jpg,.jpeg,.png,.pdf" 
                                   required>
                            <small class="text-muted">Format: JPG, PNG, atau PDF (maks 2MB)</small>
                            @error('payment_proof')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload me-2"></i>Upload Bukti Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        @endif

        {{-- Waiting Verification --}}
        @if($order->status == 'waiting_verification')
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-hourglass-split text-warning" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Menunggu Verifikasi</h4>
                    <p class="text-muted mb-4">
                        Bukti pembayaran Anda sedang dalam proses verifikasi oleh admin. 
                        Kami akan memberitahu Anda segera setelah pembayaran diverifikasi.
                    </p>
                    @if($order->payment_proof_path)
                        <a href="{{ $order->payment_proof_url }}" target="_blank" class="btn btn-outline-primary">
                            <i class="bi bi-download me-2"></i>Lihat Bukti Pembayaran
                        </a>
                    @endif
                </div>
            </div>
        @endif

        {{-- Paid Status --}}
        @if($order->status == 'paid')
            <div class="card shadow-sm border-0 border-success border-3">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="fw-bold text-success mb-3">Pembayaran Diverifikasi</h4>
                    <p class="text-muted mb-4">
                        Pembayaran Anda sudah diverifikasi. Silakan download produk yang telah Anda beli.
                    </p>
                    @if($order->download_token && $order->isDownloadTokenValid())
                        <a href="{{ route('user.download', ['order' => $order->id, 'token' => $order->download_token]) }}" 
                           class="btn btn-success btn-lg">
                            <i class="bi bi-download me-2"></i>Download Produk
                        </a>
                        <p class="text-muted small mt-3 mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            Link download aktif hingga {{ $order->token_expired_at->format('d M Y, H:i') }}
                        </p>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Link download tidak tersedia atau sudah expired.
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Rejected Status --}}
        @if($order->status == 'rejected')
            <div class="card shadow-sm border-0 border-danger border-3">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-x-circle-fill text-danger" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="fw-bold text-danger mb-3">Pembayaran Ditolak</h4>
                    <p class="text-muted mb-4">
                        Maaf, pembayaran Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.
                    </p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Katalog
                    </a>
                </div>
            </div>
        @endif
    </div>

    {{-- Status Card --}}
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 sticky-top" style="top: 100px;">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-list-check me-2 text-primary"></i>Status Pesanan
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    @if($order->status == 'pending')
                        <span class="badge bg-secondary rounded-pill fs-6 px-4 py-2">
                            <i class="bi bi-clock me-1"></i>Pending
                        </span>
                        <p class="text-muted small mt-3 mb-0">Menunggu upload bukti pembayaran</p>
                    @elseif($order->status == 'waiting_verification')
                        <span class="badge bg-warning rounded-pill fs-6 px-4 py-2">
                            <i class="bi bi-hourglass-split me-1"></i>Menunggu Verifikasi
                        </span>
                        <p class="text-muted small mt-3 mb-0">Admin sedang memverifikasi pembayaran Anda</p>
                    @elseif($order->status == 'paid')
                        <span class="badge bg-success rounded-pill fs-6 px-4 py-2">
                            <i class="bi bi-check-circle me-1"></i>Lunas
                        </span>
                        <p class="text-muted small mt-3 mb-0">Pembayaran sudah diverifikasi</p>
                    @elseif($order->status == 'approved')
                        <span class="badge bg-info rounded-pill fs-6 px-4 py-2">
                            <i class="bi bi-check-circle me-1"></i>Approved
                        </span>
                        <p class="text-muted small mt-3 mb-0">Custom Design disetujui, chat aktif</p>
                    @elseif($order->status == 'in_progress')
                        <span class="badge bg-primary rounded-pill fs-6 px-4 py-2">
                            <i class="bi bi-hourglass-split me-1"></i>Proses Desain
                        </span>
                        <p class="text-muted small mt-3 mb-0">Admin sedang mengerjakan desain Anda</p>
                    @elseif($order->status == 'revision')
                        <span class="badge bg-warning rounded-pill fs-6 px-4 py-2">
                            <i class="bi bi-arrow-repeat me-1"></i>Revisi
                        </span>
                        <p class="text-muted small mt-3 mb-0">Menunggu feedback revisi dari Anda</p>
                    @elseif($order->status == 'completed')
                        <span class="badge bg-success rounded-pill fs-6 px-4 py-2">
                            <i class="bi bi-check-all me-1"></i>Selesai
                        </span>
                        <p class="text-muted small mt-3 mb-0">Desain sudah selesai dan final</p>
                    @elseif($order->status == 'rejected')
                        <span class="badge bg-danger rounded-pill fs-6 px-4 py-2">
                            <i class="bi bi-x-circle me-1"></i>Ditolak
                        </span>
                        <p class="text-muted small mt-3 mb-0">Pembayaran ditolak oleh admin</p>
                    @else
                        <span class="badge bg-secondary rounded-pill fs-6 px-4 py-2">
                            {{ ucfirst($order->status) }}
                        </span>
                        <p class="text-muted small mt-3 mb-0">Status tidak dikenal</p>
                    @endif
                </div>

                <hr>

                <div class="small">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Pembayaran</span>
                        <strong>Rp {{ number_format($order->amount, 0, ',', '.') }}</strong>
                    </div>
                </div>
                
                {{-- Chat Button for Custom Design --}}
                @if($order->isCustomDesign() && $order->isChatActive())
                    <hr>
                    <a href="{{ route('orders.chat', $order) }}" class="btn btn-primary w-100">
                        <i class="bi bi-chat-dots me-2"></i>Chat dengan Admin
                    </a>
                    <small class="text-muted d-block mt-2 text-center">
                        <i class="bi bi-info-circle me-1"></i>Chat aktif untuk Custom Design
                    </small>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- File History Section (Custom Design) --}}
@if($order->isCustomDesign() && $order->customDesignFiles()->count() > 0)
    <div class="container-fluid px-3 px-md-4 pb-4">
        <div class="row">
            <div class="col-lg-8">
                <x-file-history :order="$order" :showActions="true" />
                
                {{-- Upload Revision Button --}}
                @if(in_array($order->status, ['in_progress', 'revision']))
                    <div class="card shadow-sm border-0 rounded-3 mt-4">
                        <div class="card-body text-center py-4">
                            <h6 class="mb-3">
                                <i class="bi bi-chat-left-text me-2 text-warning"></i>
                                Butuh Revisi?
                            </h6>
                            <p class="text-muted small mb-3">
                                Upload feedback atau file revisi untuk perbaikan desain
                            </p>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#uploadRevisionModal">
                                <i class="bi bi-upload me-2"></i>Upload Revisi / Feedback
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif

{{-- Upload Revision Modal --}}
<div class="modal fade" id="uploadRevisionModal" tabindex="-1" aria-labelledby="uploadRevisionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="uploadRevisionModalLabel">
                    <i class="bi bi-chat-left-text me-2"></i>Upload Revisi / Feedback
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('user.orders.upload-revision', $order) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="revision_notes" class="form-label fw-semibold">
                            Catatan Revisi <span class="text-danger">*</span>
                        </label>
                        <textarea 
                            class="form-control @error('revision_notes') is-invalid @enderror" 
                            id="revision_notes" 
                            name="revision_notes" 
                            rows="4" 
                            maxlength="500"
                            required
                            placeholder="Jelaskan apa yang perlu direvisi atau feedback Anda tentang desain..."></textarea>
                        @error('revision_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Minimal 10 karakter, maksimal 500 karakter</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="revision_file" class="form-label fw-semibold">
                            File Revisi (Opsional)
                        </label>
                        <input type="file" 
                               class="form-control @error('revision_file') is-invalid @enderror" 
                               id="revision_file" 
                               name="revision_file" 
                               accept=".pdf,.zip,.rar,.png,.jpg,.jpeg">
                        @error('revision_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            Format: PDF, ZIP, RAR, JPG, PNG | Max: 10MB
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-send me-2"></i>Kirim Revisi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
