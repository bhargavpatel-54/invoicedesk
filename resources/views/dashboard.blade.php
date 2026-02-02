@extends('layouts.app')

@section('title', 'Dashboard')

@section('extra-css')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endsection

@section('content')

<!-- Page Header (Dashboard Specific) -->
<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <!-- Desktop Header -->
        <div class="d-none d-md-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="mb-2 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-speedometer2 me-2"></i>Business Overview
                </h5>
                <div class="bg-light rounded-pill p-1 d-inline-flex">
                    <button class="btn btn-sm btn-primary rounded-pill px-3 fw-bold">Analytics</button>
                    <button class="btn btn-sm btn-light rounded-pill px-3 text-muted">Quick View</button>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted small">Period:</span>
                <div class="dropdown">
                    <button class="btn btn-sm btn-white border shadow-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        This Month
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                        <li><a class="dropdown-item" href="#">Past Month</a></li>
                        <li><a class="dropdown-item" href="#">Last 3 Months</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Current F.Y. Year</a></li>
                    </ul>
                </div>
                <button class="btn btn-sm btn-primary text-white shadow-sm"><i class="bi bi-printer"></i></button>
            </div>
        </div>

        <!-- Mobile Header -->
        <div class="d-md-none">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    Dashboard
                </h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-white border shadow-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Month
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">Last Month</a></li>
                    </ul>
                </div>
            </div>
            <div class="bg-light rounded-pill p-1 d-flex">
                <button class="btn btn-sm btn-primary rounded-pill flex-fill fw-bold">Analytics</button>
                <button class="btn btn-sm btn-light rounded-pill flex-fill text-muted">Quick View</button>
            </div>
        </div>
    </div>
</div>

<!-- Row 1: Summary Cards -->
<div class="row g-3 g-md-4 mb-4">
    <!-- Sale Card -->
    <div class="col-6 col-md-3">
        <div class="card h-100 border-0 shadow-sm card-dashboard">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-start mb-2 mb-md-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center summary-icon-box" 
                            style="background: linear-gradient(135deg, rgba(0, 200, 83, 0.1), rgba(0, 230, 118, 0.15));">
                        <i class="bi bi-graph-up-arrow" style="color: #00c853;"></i>
                    </div>
                </div>
                <h6 class="text-muted extra-small fw-semibold mb-1" style="letter-spacing: 1px;">SALES</h6>
                <h4 class="fw-bold mb-1">₹ 4.5L</h4>
                <div style="width: 100%; height: 30px;">
                    <canvas id="miniChartSale"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- Purchase Card -->
    <div class="col-6 col-md-3">
        <div class="card h-100 border-0 shadow-sm card-dashboard">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-start mb-2 mb-md-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center summary-icon-box" 
                            style="background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 179, 0, 0.15));">
                        <i class="bi bi-cart-check" style="color: #ffc107;"></i>
                    </div>
                </div>
                <h6 class="text-muted extra-small fw-semibold mb-1" style="letter-spacing: 1px;">PURCHASE</h6>
                <h4 class="fw-bold mb-1">₹ 1.5L</h4>
                <div style="width: 100%; height: 30px;">
                    <canvas id="miniChartPurchase"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- Payable Card -->
    <div class="col-6 col-md-3">
        <div class="card h-100 border-0 shadow-sm card-dashboard">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-start mb-2 mb-md-3 text-truncate">
                    <div class="rounded-circle d-flex align-items-center justify-content-center summary-icon-box" 
                            style="background: linear-gradient(135deg, rgba(255, 87, 34, 0.1), rgba(244, 67, 54, 0.15));">
                        <i class="bi bi-wallet2" style="color: #ff5722;"></i>
                    </div>
                </div>
                <h6 class="text-muted extra-small fw-semibold mb-1" style="letter-spacing: 1px;">PAYABLE</h6>
                <h4 class="fw-bold mb-1">₹ 25k</h4>
                <small class="text-muted d-block text-truncate" style="font-size: 10px;">4 Vendors</small>
            </div>
        </div>
    </div>
    <!-- Receivable Card -->
    <div class="col-6 col-md-3">
        <div class="card h-100 border-0 shadow-sm card-dashboard">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-start mb-2 mb-md-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center summary-icon-box" 
                            style="background: linear-gradient(135deg, rgba(33, 150, 243, 0.1), rgba(3, 169, 244, 0.15));">
                        <i class="bi bi-cash-stack" style="color: #2196f3;"></i>
                    </div>
                </div>
                <h6 class="text-muted extra-small fw-semibold mb-1" style="letter-spacing: 1px;">RECEIVABLE</h6>
                <h4 class="fw-bold mb-1">₹ 82k</h4>
                <small class="text-muted d-block text-truncate" style="font-size: 10px;">12 Invoices</small>
            </div>
        </div>
    </div>
</div>

<!-- Row 2: Outstanding Sections -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm card-dashboard h-100">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold mb-0 small uppercase">Sales Outstanding</h6>
            </div>
            <div class="card-body pt-0">
                <div class="mb-3">
                    <div class="d-flex justify-content-between small text-muted mb-1">
                        <span>Current</span>
                        <span class="fw-bold text-dark">₹ 45k</span>
                    </div>
                    <div class="progress rounded-pill" style="height: 6px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 65%"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between small text-muted mb-1">
                        <span>Overdue</span>
                        <span class="fw-bold text-danger">₹ 12k</span>
                    </div>
                    <div class="progress rounded-pill" style="height: 6px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 25%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm card-dashboard h-100">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold mb-0 small uppercase">Purchase Outstanding</h6>
            </div>
            <div class="card-body pt-0">
                <div class="mb-3">
                    <div class="d-flex justify-content-between small text-muted mb-1">
                        <span>Current</span>
                        <span class="fw-bold text-dark">₹ 10k</span>
                    </div>
                    <div class="progress rounded-pill" style="height: 6px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 40%"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between small text-muted mb-1">
                        <span>Overdue</span>
                        <span class="fw-bold text-warning">₹ 2k</span>
                    </div>
                    <div class="progress rounded-pill" style="height: 6px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 15%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 3: Main Analysis -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm card-dashboard h-100">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 small">INCOME & EXPENSE</h6>
            </div>
            <div class="card-body">
                <div style="height: 300px;">
                    <canvas id="mainTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm card-dashboard h-100">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold mb-0 small">REGIONAL SALES</h6>
            </div>
            <div class="card-body p-0">
                <div id="regionMap" style="height: 300px; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Row 4: Secondary Charts & Best Selling -->
<div class="row g-4">
    <div class="col-md-12 col-xl-4">
        <div class="card border-0 shadow-sm card-dashboard h-100">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold mb-0 small">OPERATING COST</h6>
            </div>
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                <div style="width: 150px; height: 150px;">
                    <canvas id="donutChart1"></canvas>
                </div>
                <div class="mt-3 text-center">
                    <h5 class="fw-bold mb-0">₹ 12,000</h5>
                    <small class="text-muted">Total Cost</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-4">
        <div class="card border-0 shadow-sm card-dashboard h-100">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold mb-0 small">NET PROFIT MARGIN</h6>
            </div>
            <div class="card-body">
                <div style="height: 200px;">
                    <canvas id="profitBarChart"></canvas>
                </div>
                <div class="mt-3 text-center">
                    <h5 class="fw-bold mb-0 text-success">₹ 42,500</h5>
                    <small class="text-muted">Total Profit</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-4">
        <div class="card border-0 shadow-sm card-dashboard h-100">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 small">BEST SELLING PRODUCTS</h6>
                <a href="#" class="extra-small text-decoration-none text-primary fw-bold">VIEW ALL</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted extra-small">
                        <tr>
                            <th class="ps-4">PRODUCT</th>
                            <th class="text-end">VOL</th>
                            <th class="text-end pe-4">REVENUE</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        <tr>
                            <td class="ps-4 fw-medium text-dark">SS Washer 12mm</td>
                            <td class="text-end">1.2k</td>
                            <td class="text-end pe-4 fw-bold">₹ 45k</td>
                        </tr>
                        <tr>
                            <td class="ps-4 fw-medium text-dark">Hero Nut Bolt</td>
                            <td class="text-end">850</td>
                            <td class="text-end pe-4 fw-bold">₹ 32k</td>
                        </tr>
                        <tr>
                            <td class="ps-4 fw-medium text-dark">MS Bolt 10mm</td>
                            <td class="text-end">600</td>
                            <td class="text-end pe-4 fw-bold">₹ 18k</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .summary-icon-box {
        width: 48px;
        height: 48px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .summary-icon-box i { font-size: 1.25rem; }
    
    @media (min-width: 768px) {
        .summary-icon-box {
            width: 56px;
            height: 56px;
        }
        .summary-icon-box i { font-size: 1.5rem; }
    }
    
    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
    .extra-small { font-size: 11px; }
</style>

@endsection

@section('extra-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
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

        // 2. Mini Chart Purchase
        new Chart(document.getElementById('miniChartPurchase'), {
            type: 'bar',
            data: {
                labels: ['M', 'T', 'W', 'T', 'F', 'S'],
                datasets: [{
                    data: [10, 15, 8, 12, 10, 14],
                    backgroundColor: '#ffc107',
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

        // 3. Main Trend Chart
        new Chart(document.getElementById('mainTrendChart'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Income',
                    data: [65, 59, 80, 81, 56, 55, 40, 70, 60, 75, 50, 60],
                    backgroundColor: '#00c853',
                    borderRadius: 4,
                    barPercentage: 0.6
                },
                {
                    label: 'Expense',
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

        // 4. Donut Chart
        new Chart(document.getElementById('donutChart1'), {
            type: 'doughnut',
            data: {
                labels: ['Used', 'Remaining'],
                datasets: [{
                    data: [70, 30],
                    backgroundColor: ['#00c853', '#f8f9fa'],
                    borderWidth: 0,
                    cutout: '85%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });

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

        // 6. Regional Map
        var map = L.map('regionMap').setView([20.5937, 78.9629], 4);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        
        L.marker([19.0760, 72.8777]).addTo(map).bindPopup("<b>Mumbai</b><br>Sales: ₹ 1.2L");
        L.marker([23.0225, 72.5714]).addTo(map).bindPopup("<b>Ahmedabad</b><br>Sales: ₹ 75k");

        setTimeout(function () { map.invalidateSize(); }, 500);
    });
</script>
@endsection
