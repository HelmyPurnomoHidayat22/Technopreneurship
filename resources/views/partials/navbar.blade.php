{{-- Main Navbar (User & Guest) - SIMPLIFIED FOR DEBUGGING --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="DigitalCreativeHub" style="height: 50px; width: auto; margin-right: 10px;">
            <span>DigitalCreativeHub</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                @guest
                    {{-- GUEST MENU --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="bi bi-house me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">
                            <i class="bi bi-grid me-1"></i>Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Masuk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-light btn-sm ms-2" href="{{ route('register') }}">
                            <i class="bi bi-person-plus me-1"></i>Daftar
                        </a>
                    </li>
                @endguest

                @auth
                    @if(auth()->user()->role === 'user')
                        {{-- USER MENU --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">
                                <i class="bi bi-house me-1"></i>Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">
                                <i class="bi bi-grid me-1"></i>Produk
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.orders.index') }}">
                                <i class="bi bi-bag-check me-1"></i>Pesanan Saya
                            </a>
                        </li>
                        
                        
                        <!-- Profile Dropdown (Custom) -->
                        <li class="nav-item" style="position: relative;">
                            <a class="nav-link" href="javascript:void(0)" onclick="toggleUserProfileMenu()">
                                <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }} <i class="bi bi-chevron-down"></i>
                            </a>
                            <ul id="userProfileMenu" style="display: none; position: absolute; right: 0; top: 100%; background: white; min-width: 200px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); border-radius: 8px; list-style: none; padding: 8px 0; margin: 5px 0 0 0; z-index: 1000;">
                                <li>
                                    <a href="{{ route('user.profile.edit') }}" style="display: block; padding: 10px 16px; color: #333; text-decoration: none;">
                                        <i class="bi bi-person-gear me-2"></i>Edit Profil
                                    </a>
                                </li>
                                <li><hr style="margin: 5px 0; border-top: 1px solid #eee;"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 10px 16px; color: #dc3545; cursor: pointer; font-size: inherit;">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        
                        <script>
                            function toggleUserProfileMenu() {
                                const menu = document.getElementById('userProfileMenu');
                                menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
                            }
                            
                            // Close when clicking outside
                            document.addEventListener('click', function(e) {
                                const menu = document.getElementById('userProfileMenu');
                                if (menu && !e.target.closest('.nav-item')) {
                                    menu.style.display = 'none';
                                }
                            });
                        </script>
                    @elseif(auth()->user()->role === 'admin')
                        {{-- ADMIN FALLBACK --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i>Dashboard Admin
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm ms-2">
                                    <i class="bi bi-box-arrow-right me-1"></i>Logout
                                </button>
                            </form>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>
    </div>
</nav>
