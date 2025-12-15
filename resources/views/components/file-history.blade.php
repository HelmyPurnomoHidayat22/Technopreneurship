{{-- File History Component for Custom Design Orders --}}
@props(['order', 'showActions' => true])

@if($order->isCustomDesign() && $order->customDesignFiles()->count() > 0)
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-folder2-open me-2 text-primary"></i>Histori File Design
                @if($order->status == 'completed')
                    <span class="badge bg-success ms-2">
                        <i class="bi bi-check-circle me-1"></i>Final
                    </span>
                @endif
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="10%">Versi</th>
                            <th width="15%">Tipe</th>
                            <th width="20%">Diunggah Oleh</th>
                            <th width="20%">Tanggal</th>
                            <th width="25%">Catatan</th>
                            @if($showActions)
                                <th width="10%">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->customDesignFiles()->orderBy('created_at', 'desc')->get() as $file)
                            <tr>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary fs-6">
                                        v{{ $file->version }}
                                    </span>
                                </td>
                                <td>
                                    @if($file->file_type == 'design')
                                        <span class="badge bg-success">
                                            <i class="bi bi-palette me-1"></i>Design
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="bi bi-chat-left-text me-1"></i>Revisi
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person-circle me-2 text-muted fs-5"></i>
                                        <div>
                                            <div class="fw-semibold">{{ $file->uploader->name }}</div>
                                            <small class="text-muted">{{ ucfirst($file->uploader_role) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $file->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $file->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $file->notes ?? '-' }}</small>
                                </td>
                                @if($showActions)
                                    <td>
                                        @if(auth()->user()->role === 'admin')
                                            <a href="{{ route('admin.orders.download-design-file', [$order, $file]) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Download">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        @else
                                            @if($file->file_type == 'design')
                                                <a href="{{ route('user.orders.download-design', [$order, $file]) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Download">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
