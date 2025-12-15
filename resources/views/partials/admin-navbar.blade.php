{{-- Admin Navbar - SIMPLIFIED --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="DigitalCreativeHub" style="height: 50px; width: auto; margin-right: 10px;">
            <span>DigitalCreativeHub Admin</span>
            <span class="badge bg-light text-primary ms-2">Admin</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav ms-auto align-items-center">
                @auth
                    <!-- Admin Profile Dropdown -->
                    <li class="nav-item" style="position: relative;">
                        <a class="nav-link" href="javascript:void(0)" onclick="toggleAdminProfileMenu()" style="cursor: pointer;">
                            <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }} <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul id="adminProfileMenu" style="display: none; position: absolute; right: 0; top: 100%; background: white; min-width: 180px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); border-radius: 8px; list-style: none; padding: 8px 0; margin: 5px 0 0 0; z-index: 1000;">
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
                        function toggleAdminProfileMenu() {
                            const menu = document.getElementById('adminProfileMenu');
                            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
                        }
                        
                        // Close when clicking outside
                        document.addEventListener('click', function(e) {
                            const menu = document.getElementById('adminProfileMenu');
                            if (menu && !e.target.closest('li[style*="position: relative"]')) {
                                menu.style.display = 'none';
                            }
                        });
                    </script>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Login
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
