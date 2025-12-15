{{-- Admin Sidebar --}}
<aside class="sidebar bg-white shadow-sm" style="width: 260px; min-height: calc(100vh - 56px);">
    <nav class="sidebar-nav p-3">
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                   href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" 
                   href="{{ route('admin.products.index') }}">
                    <i class="bi bi-box-seam me-2"></i>
                    <span>Produk</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" 
                   href="{{ route('admin.orders.index') }}">
                    <i class="bi bi-receipt me-2"></i>
                    <span>Pesanan</span>
                    @php
                        $pendingCount = \App\Models\Order::where('status', 'waiting_verification')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="badge bg-danger rounded-pill ms-auto">{{ $pendingCount }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                   href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people me-2"></i>
                    <span>User</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" 
                   href="{{ route('admin.reports.index') }}">
                    <i class="bi bi-graph-up me-2"></i>
                    <span>Laporan</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>

<style>
.sidebar {
    position: sticky;
    top: 56px;
}

.sidebar-nav .nav-link {
    color: #6b7280;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    text-decoration: none;
}

.sidebar-nav .nav-link:hover {
    background-color: #f3f4f6;
    color: var(--primary-color);
    transform: translateX(4px);
}

.sidebar-nav .nav-link.active {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    color: white;
    font-weight: 600;
}

.sidebar-nav .nav-link i {
    width: 20px;
    text-align: center;
}

@media (max-width: 992px) {
    .sidebar {
        position: fixed;
        left: -260px;
        top: 56px;
        z-index: 1000;
        transition: left 0.3s ease;
    }
    
    .sidebar.show {
        left: 0;
    }
}
</style>


