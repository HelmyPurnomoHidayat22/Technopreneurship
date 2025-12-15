@extends('layouts.admin')

@section('title', 'Kelola User')

@section('content')
{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-people me-2 text-primary"></i>Kelola User
        </h2>
        <p class="text-muted mb-0">Daftar semua pengguna terdaftar</p>
    </div>
</div>

{{-- Users Table --}}
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th class="text-center">Total Pesanan</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="ps-4">
                                <span class="text-muted fw-semibold">#{{ $user->id }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 40px; height: 40px;">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <strong>{{ $user->name }}</strong>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted">{{ $user->email }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary rounded-pill">{{ $user->orders_count }}</span>
                            </td>
                            <td class="text-center pe-4">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                                <h5 class="text-muted mb-0">Belum ada user</h5>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- Pagination --}}
    @if($users->hasPages())
        <div class="card-footer bg-white border-top">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div class="pagination-info text-center text-md-start mb-0">
                    Menampilkan <strong>{{ $users->firstItem() }}</strong> sampai <strong>{{ $users->lastItem() }}</strong> dari <strong>{{ $users->total() }}</strong> user
                </div>
                <nav aria-label="Users pagination" class="d-flex justify-content-center">
                    {{ $users->links() }}
                </nav>
            </div>
        </div>
    @endif
</div>
@endsection
