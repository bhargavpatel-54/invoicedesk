<!-- Mobile Sidebar Navigation -->
<div class="mobile-sidebar" id="mobileSidebar">
    <div class="mobile-sidebar-header">
        <h5 class="mb-0 fw-bold text-white">
            <i class="bi bi-receipt-cutoff me-2"></i>Menu
        </h5>
        <button class="btn-close btn-close-white" id="closeSidebar"></button>
    </div>
    <div class="mobile-sidebar-body">
        <a href="{{ route('dashboard') }}" class="mobile-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('customers.index') }}" class="mobile-nav-item {{ request()->routeIs('customers.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            <span>Customer / Vendor</span>
        </a>
        <a href="{{ route('products.index') }}" class="mobile-nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            <span>Products / Services</span>
        </a>
        <a href="{{ route('invoices.index') }}" class="mobile-nav-item {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i>
            <span>Sale Invoice</span>
        </a>
        <a href="{{ route('purchase-invoice') }}" class="mobile-nav-item {{ request()->routeIs('purchase-invoice') ? 'active' : '' }}">
            <i class="bi bi-cart"></i>
            <span>Purchase Invoice</span>
        </a>
        <a href="{{ route('payment') }}" class="mobile-nav-item {{ request()->routeIs('payment') ? 'active' : '' }}">
            <i class="bi bi-currency-rupee"></i>
            <span>Payment</span>
        </a>
        <a href="{{ route('expense-income') }}" class="mobile-nav-item {{ request()->routeIs('expense-income') ? 'active' : '' }}">
            <i class="bi bi-wallet2"></i>
            <span>Expense Income</span>
        </a>
        <a href="{{ route('other-documents') }}" class="mobile-nav-item {{ request()->routeIs('other-documents') ? 'active' : '' }}">
            <i class="bi bi-folder2"></i>
            <span>Other Documents</span>
        </a>
        <a href="{{ route('report') }}" class="mobile-nav-item {{ request()->routeIs('report') ? 'active' : '' }}">
            <i class="bi bi-bar-chart"></i>
            <span>Report</span>
        </a>
        <hr class="my-3 border-light opacity-25">
        <a href="{{ route('invoices.create') }}" class="mobile-nav-item">
            <i class="bi bi-plus-circle"></i>
            <span>New Invoice</span>
        </a>
        <a href="{{ route('customers.create') }}" class="mobile-nav-item">
            <i class="bi bi-person-plus"></i>
            <span>New Client</span>
        </a>
        <a href="{{ route('products.create') }}" class="mobile-nav-item">
            <i class="bi bi-box-seam"></i>
            <span>New Product</span>
        </a>
        <hr class="my-3 border-light opacity-25">
        <a href="{{ route('settings') }}" class="mobile-nav-item {{ request()->routeIs('settings') ? 'active' : '' }}">
            <i class="bi bi-gear"></i>
            <span>Settings</span>
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="mobile-nav-item text-danger border-0 bg-transparent w-100 text-start">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Header / Navigation -->
<header class="fixed-top">
    <!-- Top Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary py-2">
        <div class="container-fluid px-4 position-relative">
            <!-- Hamburger Menu Button (Mobile Only) - Left Side -->
            <button class="btn btn-link text-white p-0 d-lg-none position-absolute start-0 top-50 translate-middle-y ms-3" id="hamburgerBtn" style="font-size: 1.5rem; text-decoration: none; z-index: 10;">
                <i class="bi bi-list"></i>
            </button>

            <!-- Company Name - Centered on Mobile, Left on Desktop -->
            <div class="d-flex justify-content-center justify-content-lg-start w-100">
                <a class="navbar-brand fw-bold d-flex align-items-center mx-auto mx-lg-0" href="{{ route('dashboard') }}">
                    <i class="bi bi-receipt-cutoff me-2"></i>{{ Auth::user()->company_name ?? 'SHAKTI FASTNERS' }}
                </a>
            </div>

            <button class="navbar-toggler d-none" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="topNav">
                <!-- Right Actions -->
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <div class="dropdown">
                            <button
                                class="btn btn-light btn-sm fw-semibold dropdown-toggle d-flex align-items-center gap-1"
                                type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-plus-circle-fill text-primary"></i> Create
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li><a class="dropdown-item" href="{{ route('invoices.create') }}">New Invoice</a></li>
                                <li><a class="dropdown-item" href="{{ route('customers.create') }}">New Client</a></li>
                                <li><a class="dropdown-item" href="{{ route('products.create') }}">New Product</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button
                                class="btn btn-light btn-sm fw-semibold dropdown-toggle d-flex align-items-center gap-1"
                                type="button" data-bs-toggle="dropdown">
                                F.Y. 2025-2026
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li><a class="dropdown-item" href="#">F.Y. 2024-2025</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="nav-link text-white p-1" href="#"><i class="bi bi-keyboard"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white p-1" href="#"><i class="bi bi-bell"></i></a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <a class="nav-link text-white p-1 dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle fs-5"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('report') }}">Reports</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Icon Navigation (Hidden on Mobile) -->
    <div class="bg-white border-bottom shadow-sm d-none d-lg-block">
        <div class="container-fluid px-0">
            <div class="d-flex flex-nowrap overflow-auto py-0 main-nav-scroller">
                <a href="{{ route('dashboard') }}"
                    class="nav-item-box {{ request()->routeIs('dashboard') ? 'active' : '' }} text-decoration-none text-center px-3 py-2 text-secondary d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-speedometer2 fs-5 mb-1"></i>
                    <span class="small fw-medium">Dashboard</span>
                </a>
                <div class="vr my-2 opacity-25"></div>
                <a href="{{ route('customers.index') }}"
                    class="nav-item-box {{ request()->routeIs('customers.*') ? 'active' : '' }} text-decoration-none text-center px-3 py-2 text-secondary d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-people fs-5 mb-1"></i>
                    <span class="small fw-medium">Customer / Vendor</span>
                </a>
                <div class="vr my-2 opacity-25"></div>
                <a href="{{ route('products.index') }}"
                    class="nav-item-box {{ request()->routeIs('products.*') ? 'active' : '' }} text-decoration-none text-center px-3 py-2 text-secondary d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-box-seam fs-5 mb-1"></i>
                    <span class="small fw-medium">Products / Services</span>
                </a>
                <div class="vr my-2 opacity-25"></div>
                <a href="{{ route('invoices.index') }}"
                    class="nav-item-box {{ request()->routeIs('invoices.*') ? 'active' : '' }} text-decoration-none text-center px-3 py-2 text-secondary d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-file-earmark-text fs-5 mb-1"></i>
                    <span class="small fw-medium">Sale Invoice</span>
                </a>
                <div class="vr my-2 opacity-25"></div>
                <a href="{{ route('purchase-invoice') }}"
                    class="nav-item-box {{ request()->routeIs('purchase-invoice') ? 'active' : '' }} text-decoration-none text-center px-3 py-2 text-secondary d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-cart fs-5 mb-1"></i>
                    <span class="small fw-medium">Purchase Invoice</span>
                </a>
                <div class="vr my-2 opacity-25"></div>
                <a href="{{ route('payment') }}"
                    class="nav-item-box {{ request()->routeIs('payment') ? 'active' : '' }} text-decoration-none text-center px-3 py-2 text-secondary d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-currency-rupee fs-5 mb-1"></i>
                    <span class="small fw-medium">Payment</span>
                </a>
                <div class="vr my-2 opacity-25"></div>
                <a href="{{ route('expense-income') }}"
                    class="nav-item-box {{ request()->routeIs('expense-income') ? 'active' : '' }} text-decoration-none text-center px-3 py-2 text-secondary d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-wallet2 fs-5 mb-1"></i>
                    <span class="small fw-medium">Expense Income</span>
                </a>
                <div class="vr my-2 opacity-25"></div>
                <a href="{{ route('other-documents') }}"
                    class="nav-item-box {{ request()->routeIs('other-documents') ? 'active' : '' }} text-decoration-none text-center px-3 py-2 text-secondary d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-folder2 fs-5 mb-1"></i>
                    <span class="small fw-medium">Other Documents</span>
                </a>
                <div class="vr my-2 opacity-25"></div>
                <a href="{{ route('report') }}"
                    class="nav-item-box {{ request()->routeIs('report') ? 'active' : '' }} text-decoration-none text-center px-3 py-2 text-secondary d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-bar-chart fs-5 mb-1"></i>
                    <span class="small fw-medium">Report</span>
                </a>
            </div>
        </div>
    </div>
</header>

<!-- Content Spacer for Fixed Header (Responsive) -->
<div class="d-lg-none" style="padding-top: 60px;"></div>
<div class="d-none d-lg-block" style="padding-top: 110px;"></div>

<!-- Mobile Sidebar JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const closeSidebar = document.getElementById('closeSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        // Open sidebar
        if (hamburgerBtn) {
            hamburgerBtn.addEventListener('click', function() {
                mobileSidebar.classList.add('active');
                sidebarOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        }

        // Close sidebar
        function closeSidebarFunc() {
            mobileSidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        if (closeSidebar) {
            closeSidebar.addEventListener('click', closeSidebarFunc);
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeSidebarFunc);
        }
    });
</script>
