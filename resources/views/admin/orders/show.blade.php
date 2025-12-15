@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-receipt me-2 text-primary"></i>Detail Pesanan
        </h2>
        <p class="text-muted mb-0">Kode: <code class="bg-light px-2 py-1 rounded">{{ $order->order_code }}</code></p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row g-4">
    {{-- Order Information --}}
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-info-circle me-2 text-primary"></i>Informasi Pesanan
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-muted small">Nama Pelanggan</label>
                        <p class="fw-semibold mb-0">{{ $order->customer_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Email</label>
                        <p class="fw-semibold mb-0">{{ $order->customer_email }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">No. Telepon</label>
                        <p class="fw-semibold mb-0">{{ $order->customer_phone }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Tanggal Pesanan</label>
                        <p class="fw-semibold mb-0">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Product Information --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-box-seam me-2 text-primary"></i>Produk
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center">
                    @if($order->product->preview_image)
                        <img src="{{ $order->product->preview_image_url }}" 
                             class="rounded me-3 shadow-sm" 
                             style="width: 100px; height: 100px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                             style="width: 100px; height: 100px;">
                            <i class="bi bi-image text-muted fs-3"></i>
                        </div>
                    @endif
                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-2">{{ $order->product->title }}</h5>
                        <p class="text-muted mb-2">{{ $order->product->category->name }}</p>
                        <h4 class="text-primary mb-0">Rp {{ number_format($order->amount, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Custom Design Details (if applicable) --}}
        @if($order->custom_category || $order->custom_notes)
            <div class="card shadow-sm border-0 mb-4">
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
                                <span class="badge bg-primary-subtle text-primary px-3 py-2 fs-6">
                                    <i class="bi bi-tag me-1"></i>{{ $order->custom_category }}
                                </span>
                            </p>
                        </div>
                    @endif

                    @if($order->custom_notes)
                        <div>
                            <label class="form-label fw-semibold text-muted small">Catatan dari Pelanggan</label>
                            <div class="bg-light rounded p-3">
                                <p class="mb-0" style="white-space: pre-wrap;">{{ $order->custom_notes }}</p>
                            </div>
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Gunakan catatan ini sebagai brief untuk proses desain
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Payment Proof --}}
        @if($order->payment_proof_path)
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-receipt-cutoff me-2 text-primary"></i>Bukti Pembayaran
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ $order->payment_proof_url }}" target="_blank" class="btn btn-primary">
                            <i class="bi bi-download me-2"></i>Lihat Bukti Pembayaran
                        </a>
                    </div>
                    @if($order->status == 'waiting_verification')
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-clock me-2"></i>
                            <strong>Menunggu Verifikasi:</strong> Silakan periksa bukti pembayaran dan verifikasi pesanan ini.
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- File History Component --}}
        @if($order->isCustomDesign())
            <x-file-history :order="$order" :showActions="true" />
        @endif
    </div>

    {{-- Status & Actions --}}
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 sticky-top" style="top: 100px;">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-list-check me-2 text-primary"></i>Status & Aksi
                </h5>
            </div>
            <div class="card-body">
                {{-- Status Badge --}}
                <div class="mb-4 text-center">
                    <label class="text-muted small d-block mb-2">Status Pesanan</label>
                    @if($order->status == 'pending')
                        <span class="badge bg-secondary rounded-pill fs-6 px-3 py-2">Pending</span>
                    @elseif($order->status == 'waiting_verification')
                        <span class="badge bg-warning rounded-pill fs-6 px-3 py-2">
                            <i class="bi bi-clock me-1"></i>Menunggu Verifikasi
                        </span>
                    @elseif($order->status == 'paid')
                        <span class="badge bg-success rounded-pill fs-6 px-3 py-2">
                            <i class="bi bi-check-circle me-1"></i>Lunas
                        </span>
                    @elseif($order->status == 'approved')
                        <span class="badge bg-info rounded-pill fs-6 px-3 py-2">
                            <i class="bi bi-check-circle me-1"></i>Approved
                        </span>
                    @elseif($order->status == 'in_progress')
                        <span class="badge bg-primary rounded-pill fs-6 px-3 py-2">
                            <i class="bi bi-hourglass-split me-1"></i>In Progress
                        </span>
                    @elseif($order->status == 'revision')
                        <span class="badge bg-warning rounded-pill fs-6 px-3 py-2">
                            <i class="bi bi-arrow-repeat me-1"></i>Revision
                        </span>
                    @elseif($order->status == 'completed')
                        <span class="badge bg-success rounded-pill fs-6 px-3 py-2">
                            <i class="bi bi-check-all me-1"></i>Completed
                        </span>
                    @elseif($order->status == 'rejected')
                        <span class="badge bg-danger rounded-pill fs-6 px-3 py-2">
                            <i class="bi bi-x-circle me-1"></i>Ditolak
                        </span>
                    @else
                        <span class="badge bg-secondary rounded-pill fs-6 px-3 py-2">{{ $order->status }}</span>
                    @endif
                </div>

                {{-- Action Buttons --}}
                @if($order->status == 'waiting_verification')
                    <div class="d-grid gap-2">
                        <form action="{{ route('admin.orders.verify', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('Verifikasi pembayaran ini? Pesanan akan diubah menjadi Lunas dan link download akan aktif.')">
                                <i class="bi bi-check-circle me-2"></i>Verifikasi Pembayaran
                            </button>
                        </form>
                        
                        <!-- Tolak Button (NO MODAL - Direct Inline) -->
                        <button type="button" class="btn btn-danger w-100" onclick="document.getElementById('rejectForm').style.display = document.getElementById('rejectForm').style.display === 'none' ? 'block' : 'none'">
                            <i class="bi bi-x-circle me-2"></i>Tolak Pembayaran
                        </button>
                        
                        <!-- Inline Reject Form (Hidden by default) -->
                        <div id="rejectForm" style="display: none;" class="card mt-2">
                            <div class="card-header bg-danger text-white">
                                <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Penolakan
                            </div>
                            <div class="card-body">
                                <div class="alert alert-warning">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Perhatian:</strong> Anda akan menolak pesanan ini. Harap berikan alasan yang jelas.
                                </div>
                                
                                <form action="{{ route('admin.orders.reject', $order) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="rejection_note" class="form-label fw-semibold">
                                            Catatan Penolakan <span class="text-danger">*</span>
                                        </label>
                                        <textarea 
                                            class="form-control @error('rejection_note') is-invalid @enderror" 
                                            id="rejection_note" 
                                            name="rejection_note" 
                                            rows="5" 
                                            maxlength="500"
                                            required
                                            placeholder="Contoh: File referensi kurang jelas, brief desain tidak lengkap, atau permintaan tidak sesuai dengan layanan yang kami tawarkan.">{{ old('rejection_note') }}</textarea>
                                        @error('rejection_note')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Minimal 10 karakter, maksimal 500 karakter</small>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-x-circle me-2"></i>Tolak Pesanan
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('rejectForm').style.display='none'">
                                        <i class="bi bi-x-circle me-2"></i>Batal
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @elseif($order->status == 'paid')
                    <div class="alert alert-success mb-0">
                        <i class="bi bi-check-circle me-2"></i>
                        <strong>Pesanan sudah diverifikasi</strong>
                        <p class="mb-0 small mt-2">Link download sudah aktif untuk pelanggan</p>
                    </div>
                @elseif($order->status == 'rejected')
                    <div class="alert alert-danger mb-0">
                        <i class="bi bi-x-circle me-2"></i>
                        <strong>Pesanan Ditolak</strong>
                        @if($order->rejection_note)
                            <hr>
                            <p class="mb-0 small"><strong>Catatan:</strong></p>
                            <p class="mb-0 small">{{ $order->rejection_note }}</p>
                        @endif
                        @if($order->rejected_at)
                            <p class="mb-0 small mt-2 text-muted">Ditolak pada: {{ $order->rejected_at->format('d M Y, H:i') }}</p>
                        @endif
                    </div>
                @endif
                
                {{-- Custom Design Actions --}}
                @if($order->isCustomDesign())
                    <hr class="my-3">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-palette me-2 text-primary"></i>Custom Design Actions
                    </h6>
                    
                    @if($order->status == 'paid')
                        <form action="{{ route('admin.orders.approve', $order) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-info w-100" onclick="return confirm('Approve custom design order ini? Chat akan aktif setelah approved.')">
                                <i class="bi bi-check-circle me-2"></i>Approve Custom Design
                            </button>
                        </form>
                        <small class="text-muted d-block mb-3">
                            <i class="bi bi-info-circle me-1"></i>Approve untuk mengaktifkan chat
                        </small>
                    @endif
                    
                    @if(in_array($order->status, ['approved', 'in_progress', 'revision']))
                        <!-- Upload Design Inline Form (NO MODAL) -->
                        <button type="button" class="btn btn-success w-100 mb-2" onclick="document.getElementById('uploadDesignForm').style.display = document.getElementById('uploadDesignForm').style.display === 'none' ? 'block' : 'none'">
                            <i class="bi bi-cloud-upload me-2"></i>
                            {{ $order->customDesignFiles()->where('file_type', 'design')->count() > 0 ? 'Upload Ulang Design' : 'Upload Design File' }}
                        </button>
                        
                        <!-- Inline Upload Form (Hidden by default) -->
                        <div id="uploadDesignForm" style="display: none;" class="card mb-3">
                            <div class="card-header bg-success text-white">
                                <i class="bi bi-cloud-upload me-2"></i>Upload Design File
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.orders.upload-design', $order) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="design_file" class="form-label fw-semibold">
                                            Design File <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" 
                                               class="form-control @error('design_file') is-invalid @enderror" 
                                               id="design_file" 
                                               name="design_file" 
                                               accept=".pdf,.zip,.rar,.psd,.ai,.eps,.fig,.sketch"
                                               required>
                                        @error('design_file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">
                                            Format: PDF, ZIP, RAR, PSD, AI, EPS, FIG, SKETCH | Max: 50MB
                                        </small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="notes" class="form-label fw-semibold">Catatan (Opsional)</label>
                                        <textarea 
                                            class="form-control @error('notes') is-invalid @enderror" 
                                            id="notes" 
                                            name="notes" 
                                            rows="3" 
                                            maxlength="500"
                                            placeholder="Catatan untuk customer tentang desain ini..."></textarea>
                                        @error('notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Maksimal 500 karakter</small>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-cloud-upload me-2"></i>Upload Design
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('uploadDesignForm').style.display='none'">
                                        <i class="bi bi-x-circle me-2"></i>Batal
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Mark Completed Button -->
                        <form action="{{ route('admin.orders.mark-completed', $order) }}" method="POST" class="mb-2 mt-2">
                            @csrf
                            <button type="submit" class="btn btn-dark w-100" onclick="return confirm('Mark order sebagai Selesai? Pastikan semua file desain sudah di-upload.')">
                                <i class="bi bi-check-all me-2"></i>Mark Completed
                            </button>
                        </form>
                        <small class="text-muted d-block mb-3">
                            <i class="bi bi-info-circle me-1"></i>Mark completed jika desain sudah final
                        </small>
                        
                    
                    @if($order->isChatActive())
                        <a href="{{ route('orders.chat', $order) }}" class="btn btn-outline-primary w-100 mb-2" target="_blank">
                            <i class="bi bi-chat-dots me-2"></i>Open Chat
                        </a>
                    @endif
                    
                    @if(in_array($order->status, ['approved', 'in_progress', 'revision']))
                        <div class="alert alert-info small mb-0 mt-3">
                            <i class="bi bi-lightbulb me-1"></i>
                            <strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </div>
                    @endif
                @endif
                @else
                    {{-- Tampilan untuk order biasa, hanya ditolak/lunas --}}
                   @if($order->status == 'rejected')
                        <hr class="my-3">
                        <div class="alert alert-danger mb-0">
                            <i class="bi bi-x-circle me-2"></i>
                            <strong>Pesanan Ditolak</strong>
                        </div>
                    @elseif($order->status == 'paid')
                        <hr class="my-3">
                        <div class="alert alert-success mb-0">
                            <i class="bi bi-check-circle me-2"></i>
                            <strong>Pesanan Lunas</strong>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Upload Design Modal --}}
<div class="modal fade" id="uploadDesignModal" tabindex="-1" aria-labelledby="uploadDesignModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="uploadDesignModalLabel">
                    <i class="bi bi-cloud-upload me-2"></i>Upload Design File
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.orders.upload-design', $order) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="design_file" class="form-label fw-semibold">
                            Design File <span class="text-danger">*</span>
                        </label>
                        <input type="file" 
                               class="form-control @error('design_file') is-invalid @enderror" 
                               id="design_file" 
                               name="design_file" 
                               accept=".pdf,.zip,.rar,.psd,.ai,.eps,.fig,.sketch"
                               required>
                        @error('design_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            Format: PDF, ZIP, RAR, PSD, AI, EPS, FIG, SKETCH | Max: 50MB
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label fw-semibold">Catatan (Opsional)</label>
                        <textarea 
                            class="form-control @error('notes') is-invalid @enderror" 
                            id="notes" 
                            name="notes" 
                            rows="3" 
                            maxlength="500"
                            placeholder="Catatan untuk customer tentang desain ini..."></textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Maksimal 500 karakter</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-cloud-upload me-2"></i>Upload Design
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Rejection Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="rejectModalLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Penolakan Pesanan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.orders.reject', $order) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Perhatian:</strong> Anda akan menolak pesanan ini. Harap berikan alasan yang jelas kepada pelanggan.
                    </div>

                    <div class="mb-3">
                        <label for="rejection_note" class="form-label fw-semibold">
                            Catatan Penolakan <span class="text-danger">*</span>
                        </label>
                        <textarea 
                            class="form-control @error('rejection_note') is-invalid @enderror" 
                            id="rejection_note" 
                            name="rejection_note" 
                            rows="5" 
                            maxlength="500"
                            required
                            placeholder="Contoh: File referensi kurang jelas, brief desain tidak lengkap, atau permintaan tidak sesuai dengan layanan yang kami tawarkan."
                        >{{ old('rejection_note') }}</textarea>
                        @error('rejection_note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <span id="charCount">0</span>/500 karakter (minimal 10 karakter)
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-circle me-2"></i>Tolak Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Character counter
    const textarea = document.getElementById('rejection_note');
    const charCount = document.getElementById('charCount');
    
    if (textarea && charCount) {
        textarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    }
</script>
@endsection
