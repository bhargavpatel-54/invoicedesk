<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Settings - InvoiceDesk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>

    <!-- Mobile Sidebar Navigation -->
    <div class="mobile-sidebar" id="mobileSidebar">
        <div class="mobile-sidebar-header">
            <h5 class="mb-0 fw-bold text-white">
                <i class="bi bi-receipt-cutoff me-2"></i>Menu
            </h5>
            <button class="btn-close btn-close-white" id="closeSidebar"></button>
        </div>
        <div class="mobile-sidebar-body">
            <a href="{{ route('dashboard') }}" class="mobile-nav-item">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('customers.index') }}" class="mobile-nav-item">
                <i class="bi bi-people"></i>
                <span>Customer / Vendor</span>
            </a>
            <a href="{{ route('products.index') }}" class="mobile-nav-item">
                <i class="bi bi-box-seam"></i>
                <span>Products / Services</span>
            </a>
            <a href="{{ route('invoices.index') }}" class="mobile-nav-item">
                <i class="bi bi-file-earmark-text"></i>
                <span>Sale Invoice</span>
            </a>
            <a href="{{ route('purchase-invoice') }}" class="mobile-nav-item">
                <i class="bi bi-cart"></i>
                <span>Purchase Invoice</span>
            </a>
            <a href="{{ route('payment') }}" class="mobile-nav-item">
                <i class="bi bi-currency-rupee"></i>
                <span>Payment</span>
            </a>
            <a href="{{ route('expense-income') }}" class="mobile-nav-item">
                <i class="bi bi-wallet2"></i>
                <span>Expense Income</span>
            </a>
            <a href="{{ route('other-documents') }}" class="mobile-nav-item">
                <i class="bi bi-folder2"></i>
                <span>Other Documents</span>
            </a>
            <a href="{{ route('report') }}" class="mobile-nav-item">
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
            <a href="{{ route('settings') }}" class="mobile-nav-item active">
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
                        class="nav-item-box text-decoration-none text-center px-3 py-2 text-secondary d-flex flex-column align-items-center justify-content-center">
                        <i class="bi bi-speedometer2 fs-5 mb-1"></i>
                        <span class="small fw-medium">Dashboard</span>
                    </a>
                    <div class="vr my-2 opacity-25"></div>
                    <a href="{{ route('customers.index') }}"
                        class="nav-item-box text-decoration-none text-center px-3 py-2 text-secondary d-flex flex-column align-items-center justify-content-center">
                        <i class="bi bi-people fs-5 mb-1"></i>
                        <span class="small fw-medium">Customer / Vendor</span>
                    </a>
                    <div class="vr my-2 opacity-25"></div>
                    <a href="{{ route('products.index') }}"
                        class="nav-item-box text-decoration-none text-center px-3 py-2 text-secondary d-flex flex-column align-items-center justify-content-center">
                        <i class="bi bi-box-seam fs-5 mb-1"></i>
                        <span class="small fw-medium">Products / Services</span>
                    </a>
                    <div class="vr my-2 opacity-25"></div>
                    <a href="{{ route('invoices.index') }}"
                        class="nav-item-box text-decoration-none text-center px-3 py-2 text-secondary d-flex flex-column align-items-center justify-content-center">
                        <i class="bi bi-file-earmark-text fs-5 mb-1"></i>
                        <span class="small fw-medium">Sale Invoice</span>
                    </a>
                    <div class="vr my-2 opacity-25"></div>
                    <a href="{{ route('purchase-invoice') }}"
                        class="nav-item-box text-decoration-none text-center px-3 py-2 text-secondary d-flex flex-column align-items-center justify-content-center">
                        <i class="bi bi-cart fs-5 mb-1"></i>
                        <span class="small fw-medium">Purchase Invoice</span>
                    </a>
                    <div class="vr my-2 opacity-25"></div>
                    <a href="{{ route('payment') }}"
                        class="nav-item-box text-decoration-none text-center px-3 py-2 text-secondary d-flex flex-column align-items-center justify-content-center">
                        <i class="bi bi-currency-rupee fs-5 mb-1"></i>
                        <span class="small fw-medium">Payment</span>
                    </a>
                    <div class="vr my-2 opacity-25"></div>
                    <a href="{{ route('expense-income') }}"
                        class="nav-item-box text-decoration-none text-center px-3 py-2 text-secondary d-flex flex-column align-items-center justify-content-center">
                        <i class="bi bi-wallet2 fs-5 mb-1"></i>
                        <span class="small fw-medium">Expense Income</span>
                    </a>
                    <div class="vr my-2 opacity-25"></div>
                    <a href="{{ route('other-documents') }}"
                        class="nav-item-box text-decoration-none text-center px-3 py-2 text-secondary d-flex flex-column align-items-center justify-content-center">
                        <i class="bi bi-folder2 fs-5 mb-1"></i>
                        <span class="small fw-medium">Other Documents</span>
                    </a>
                    <div class="vr my-2 opacity-25"></div>
                    <a href="{{ route('report') }}"
                        class="nav-item-box text-decoration-none text-center px-3 py-2 text-secondary d-flex flex-column align-items-center justify-content-center">
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

    <!-- Main Content -->
    <main class="container-fluid px-4 py-4">
        
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Settings</h2>
                <p class="text-muted mb-0">Manage your account and application preferences</p>
            </div>
        </div>

        <!-- Settings Cards -->
        <div class="row g-4">
            <!-- Company Profile -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm card-dashboard h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 48px; height: 48px; background: linear-gradient(135deg, rgba(0, 200, 83, 0.1), rgba(0, 230, 118, 0.15));">
                                <i class="bi bi-building fs-4" style="color: #00c853;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Company Profile</h5>
                                <small class="text-muted">Update your company information</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Company Name</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->company_name ?? 'SHAKTI FASTNERS' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Email</label>
                            <input type="email" class="form-control" value="{{ Auth::user()->email ?? 'company@example.com' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">GST Number</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->gst_no ?? 'N/A' }}" readonly>
                        </div>
                        <button class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil me-2"></i>Edit Profile
                        </button>
                    </div>
                </div>
            </div>

            <!-- Subscription Info -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm card-dashboard h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 48px; height: 48px; background: linear-gradient(135deg, rgba(33, 150, 243, 0.1), rgba(3, 169, 244, 0.15));">
                                <i class="bi bi-calendar-check fs-4" style="color: #2196f3;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Subscription</h5>
                                <small class="text-muted">Manage your subscription plan</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Current Plan</label>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success px-3 py-2">Active</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Subscription End Date</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->subscription_end_date ? Auth::user()->subscription_end_date->format('d M Y') : 'N/A' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Days Remaining</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->daysLeft() ?? 'N/A' }}" readonly>
                        </div>
                        <button class="btn btn-primary btn-sm">
                            <i class="bi bi-arrow-repeat me-2"></i>Renew Subscription
                        </button>
                    </div>
                </div>
            </div>

            <!-- Preferences -->
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm card-dashboard">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 48px; height: 48px; background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 179, 0, 0.15));">
                                <i class="bi bi-sliders fs-4" style="color: #ffc107;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Preferences</h5>
                                <small class="text-muted">Customize your experience</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-muted">Financial Year</label>
                                <select class="form-select">
                                    <option selected>F.Y. 2025-2026</option>
                                    <option>F.Y. 2024-2025</option>
                                    <option>F.Y. 2023-2024</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold text-muted">Currency</label>
                                <select class="form-select">
                                    <option selected>INR (₹)</option>
                                    <option>USD ($)</option>
                                    <option>EUR (€)</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm">
                            <i class="bi bi-check-circle me-2"></i>Save Preferences
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </main>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
