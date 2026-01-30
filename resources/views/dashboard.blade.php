<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BillFlow - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
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
            <a href="{{ route('dashboard') }}" class="mobile-nav-item active">
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
            <a href="{{ route('settings') }}" class="mobile-nav-item">
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
                        class="nav-item-box active text-decoration-none text-center px-3 py-2 text-secondary d-flex flex-column align-items-center justify-content-center">
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

        <!-- Control Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="bg-white rounded-pill shadow-sm p-1 d-inline-flex">
                <button class="btn btn-sm btn-primary rounded-pill px-3 fw-bold">Analytics</button>
                <button class="btn btn-sm btn-white rounded-pill px-3 text-muted">Quick View</button>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted small">Period:</span>
                <div class="dropdown">
                    <button class="btn btn-sm btn-white border shadow-sm dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        This Month
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                        <li><a class="dropdown-item" href="#">Past Month</a></li>
                        <li><a class="dropdown-item" href="#">Last 3 Months</a></li>
                        <li><a class="dropdown-item" href="#">Last 6 Months</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Current F.Y. Year</a></li>
                        <li><a class="dropdown-item" href="#">Last F.Y. Year</a></li>
                    </ul>
                </div>
                <button class="btn btn-sm btn-primary text-white shadow-sm"><i class="bi bi-printer"></i></button>
            </div>
        </div>

        <!-- Row 1: Summary Cards -->
        <div class="row g-4 mb-4">
            <!-- Sale Card -->
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm card-dashboard">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 56px; height: 56px; background: linear-gradient(135deg, rgba(0, 200, 83, 0.1), rgba(0, 230, 118, 0.15)); box-shadow: 0 4px 12px rgba(0, 200, 83, 0.2);">
                                <i class="bi bi-graph-up-arrow fs-4" style="color: #00c853;"></i>
                            </div>
                            <span class="badge rounded-pill px-3 py-2" style="background: linear-gradient(135deg, rgba(0, 200, 83, 0.15), rgba(0, 230, 118, 0.15)); color: #00c853; font-weight: 600;">
                                <i class="bi bi-arrow-up"></i> +12%
                            </span>
                        </div>
                        <h6 class="text-muted small fw-semibold mb-2" style="letter-spacing: 1px;">SALES</h6>
                        <h3 class="fw-bold mb-2">₹ 450,250</h3>
                        <div style="width: 100%; height: 40px; margin-top: 12px;">
                            <canvas id="miniChartSale"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Purchase Card -->
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm card-dashboard">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 56px; height: 56px; background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 179, 0, 0.15)); box-shadow: 0 4px 12px rgba(255, 193, 7, 0.2);">
                                <i class="bi bi-cart-check fs-4" style="color: #ffc107;"></i>
                            </div>
                            <span class="badge rounded-pill px-3 py-2" style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.15), rgba(255, 0, 0, 0.1)); color: #dc3545; font-weight: 600;">
                                <i class="bi bi-arrow-down"></i> -5%
                            </span>
                        </div>
                        <h6 class="text-muted small fw-semibold mb-2" style="letter-spacing: 1px;">PURCHASE</h6>
                        <h3 class="fw-bold mb-2">₹ 150,000</h3>
                        <div style="width: 100%; height: 40px; margin-top: 12px;">
                            <canvas id="miniChartPurchase"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Payable Card -->
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm card-dashboard">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 56px; height: 56px; background: linear-gradient(135deg, rgba(255, 87, 34, 0.1), rgba(244, 67, 54, 0.15)); box-shadow: 0 4px 12px rgba(255, 87, 34, 0.2);">
                                <i class="bi bi-wallet2 fs-4" style="color: #ff5722;"></i>
                            </div>
                            <span class="badge rounded-pill px-3 py-2" style="background: rgba(255, 87, 34, 0.1); color: #ff5722; font-weight: 600;">
                                4 Pending
                            </span>
                        </div>
                        <h6 class="text-muted small fw-semibold mb-2" style="letter-spacing: 1px;">PAYABLE</h6>
                        <h3 class="fw-bold mb-1">₹ 25,000</h3>
                        <small class="text-muted d-block" style="font-size: 12px;">4 Vendors Pending</small>
                    </div>
                </div>
            </div>
            <!-- Receivable Card -->
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm card-dashboard">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 56px; height: 56px; background: linear-gradient(135deg, rgba(33, 150, 243, 0.1), rgba(3, 169, 244, 0.15)); box-shadow: 0 4px 12px rgba(33, 150, 243, 0.2);">
                                <i class="bi bi-cash-stack fs-4" style="color: #2196f3;"></i>
                            </div>
                            <span class="badge rounded-pill px-3 py-2" style="background: rgba(33, 150, 243, 0.1); color: #2196f3; font-weight: 600;">
                                12 Due
                            </span>
                        </div>
                        <h6 class="text-muted small fw-semibold mb-2" style="letter-spacing: 1px;">RECEIVABLE</h6>
                        <h3 class="fw-bold mb-1">₹ 82,000</h3>
                        <small class="text-muted d-block" style="font-size: 12px;">12 Invoices Due</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 2: Outstanding Sections -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm card-dashboard h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="fw-bold mb-0 small">SALES OUTSTANDING</h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span>Current</span>
                                <span>₹ 45,000</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 65%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span>Overdue</span>
                                <span>₹ 12,000</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 8px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 25%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm card-dashboard h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="fw-bold mb-0 small">PURCHASE OUTSTANDING</h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span>Current</span>
                                <span>₹ 10,000</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 8px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 40%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span>Overdue</span>
                                <span>₹ 2,000</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 8px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 15%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 3: Main Analysis -->
        <div class="row g-4 mb-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm card-dashboard h-100">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0 small">INCOME & EXPENSE</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="mainTrendChart" height="250"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm card-dashboard h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="fw-bold mb-0 small">REGIONAL SALES</h6>
                    </div>
                    <div class="card-body p-0">
                        <div id="regionMap"
                            style="height: 100%; min-height: 250px; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 4: Secondary Charts & Best Selling (Refactored) -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm card-dashboard h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="fw-bold mb-0 small">OPERATING COST</h6>
                    </div>
                    <div class="card-body d-flex justify-content-center">
                        <div style="width: 200px; height: 200px;">
                            <canvas id="donutChart1"></canvas>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 text-center pb-3">
                        <h5 class="fw-bold mb-0">₹ 12,000</h5>
                        <small class="text-muted">Total Cost</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm card-dashboard h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="fw-bold mb-0 small">NET PROFIT MARGIN</h6>
                    </div>
                    <div class="card-body">
                        <div style="height: 200px;">
                            <canvas id="profitBarChart"></canvas>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 text-center pb-3">
                        <h5 class="fw-bold mb-0">₹ 42,500</h5>
                        <small class="text-muted">Total Profit</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Best Selling Products (Moved from Row 5 & Refactored) -->
                <div class="card border-0 shadow-sm card-dashboard h-100">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0 small">BEST SELLING PRODUCTS</h6>
                        <a href="#" class="small text-decoration-none text-primary">View All</a>
                    </div>
                    <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted fs-7">
                                <tr>
                                    <th class="ps-4">Product Name</th>
                                    <th>Volume</th>
                                    <th class="text-end pe-4">Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4 fw-medium">SS Washer 12mm</td>
                                    <td>1.2k</td>
                                    <td class="text-end pe-4">₹ 45,000</td>
                                </tr>
                                <tr>
                                    <td class="ps-4 fw-medium">Hero Nut Bolt</td>
                                    <td>850</td>
                                    <td class="text-end pe-4">₹ 32,500</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Chart Init Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Colors
            const primaryColor = '#00c853';
            const successColor = '#00c853';
            const infoColor = '#0dcaf0';
            const warningColor = '#ffc107';

            // 1. Mini Chart Sale
            new Chart(document.getElementById('miniChartSale'), {
                type: 'bar',
                data: {
                    labels: ['M', 'T', 'W', 'T', 'F', 'S'],
                    datasets: [{
                        data: [12, 19, 10, 15, 12, 18],
                        backgroundColor: '#00c853',
                        borderRadius: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { x: { display: false }, y: { display: false } }
                }
            });

            // 2. Mini Chart Purchase (Updated to Bar and different color)
            new Chart(document.getElementById('miniChartPurchase'), {
                type: 'bar',
                data: {
                    labels: ['M', 'T', 'W', 'T', 'F', 'S'],
                    datasets: [{
                        data: [10, 15, 8, 12, 10, 14],
                        backgroundColor: '#ffc107', // Warning/Orange color
                        borderRadius: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { x: { display: false }, y: { display: false } }
                }
            });

            // 3. Main Trend Chart (Renamed to Income & Expense, removed dropdown logic)
            new Chart(document.getElementById('mainTrendChart'), {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Income', // Renamed
                        data: [65, 59, 80, 81, 56, 55, 40, 70, 60, 75, 50, 60],
                        backgroundColor: '#00c853',
                        borderRadius: 4,
                        barPercentage: 0.6
                    },
                    {
                        label: 'Expense', // Renamed
                        data: [28, 48, 40, 19, 86, 27, 90, 40, 30, 50, 40, 30],
                        backgroundColor: '#e9ecef',
                        borderRadius: 4,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', align: 'start', labels: { usePointStyle: true, boxWidth: 8 } } },
                    scales: {
                        y: { border: { display: false }, grid: { color: '#f8f9fa' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // 4. Donut Charts
            const donutConfig = (color) => ({
                type: 'doughnut',
                data: {
                    labels: ['Used', 'Remaining'],
                    datasets: [{
                        data: [70, 30],
                        backgroundColor: [color, '#f8f9fa'],
                        borderWidth: 0,
                        cutout: '80%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });

            new Chart(document.getElementById('donutChart1'), donutConfig('#00c853'));

            // 5. Profit Bar Chart
            new Chart(document.getElementById('profitBarChart'), {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Profit',
                        data: [12, 19, 15, 25, 22, 30],
                        backgroundColor: '#00c853',
                        borderRadius: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { display: true, grid: { display: false } },
                        y: { display: false }
                    }
                }
            });

            // 6. Regional Map (Leaflet)
            var map = L.map('regionMap').setView([20.5937, 78.9629], 4); // Center on India

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // Example Markers
            L.marker([19.0760, 72.8777]).addTo(map).bindPopup("<b>Mumbai</b><br>Sales: ₹ 1.2L").openPopup();
            L.marker([28.7041, 77.1025]).addTo(map).bindPopup("<b>New Delhi</b><br>Sales: ₹ 85k");
            L.marker([12.9716, 77.5946]).addTo(map).bindPopup("<b>Bangalore</b><br>Sales: ₹ 90k");
            L.marker([22.5726, 88.3639]).addTo(map).bindPopup("<b>Kolkata</b><br>Sales: ₹ 60k");
            L.marker([23.0225, 72.5714]).addTo(map).bindPopup("<b>Ahmedabad</b><br>Sales: ₹ 75k");

            // Force map resize just in case
            setTimeout(function () { map.invalidateSize(); }, 500);
        });
    </script>

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
