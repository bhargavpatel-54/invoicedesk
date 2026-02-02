@extends('layouts.app')

@section('title', 'Reports')

@section('content')

<!-- Page Header -->
<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <!-- Desktop Header (Big Screen Only) -->
        <div class="d-none d-md-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="mb-2 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-bar-chart-fill me-2"></i>Business Reports & Analytics
                </h5>
                <div class="d-flex gap-4 mt-2 small text-muted">
                    <span><i class="bi bi-circle-fill text-primary me-1" style="font-size: 8px;"></i>Period: <b class="text-dark">January 2026</b></span>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-white border shadow-sm btn-sm"><i class="bi bi-funnel me-1"></i> Filter</button>
                <button class="btn btn-primary text-white btn-sm px-3 fw-semibold shadow"><i class="bi bi-download me-1"></i> Export</button>
            </div>
        </div>

        <!-- Mobile Header (Small Screen Only) -->
        <div class="d-md-none">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-bar-chart-fill me-2"></i>Reports
                </h5>
                <button class="btn btn-primary text-white btn-sm px-3 fw-semibold shadow"><i class="bi bi-funnel"></i></button>
            </div>
            <div class="small text-muted bg-light p-2 rounded-3 text-center">
                Period: <b class="text-dark">January 2026</b>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm card-dashboard">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 56px; height: 56px; background: linear-gradient(135deg, rgba(0, 200, 83, 0.1), rgba(0, 230, 118, 0.15)); box-shadow: 0 4px 12px rgba(0, 200, 83, 0.2);">
                        <i class="bi bi-graph-up-arrow fs-4" style="color: #00c853;"></i>
                    </div>
                </div>
                <h6 class="text-muted small fw-semibold mb-2" style="letter-spacing: 1px;">TOTAL REVENUE</h6>
                <h3 class="fw-bold mb-2">₹4,50,250</h3>
                <small class="text-success fw-semibold"><i class="bi bi-arrow-up"></i> +12% from last month</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm card-dashboard">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 56px; height: 56px; background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 179, 0, 0.15)); box-shadow: 0 4px 12px rgba(255, 193, 7, 0.2);">
                        <i class="bi bi-cart-check fs-4" style="color: #ffc107;"></i>
                    </div>
                </div>
                <h6 class="text-muted small fw-semibold mb-2" style="letter-spacing: 1px;">TOTAL EXPENSES</h6>
                <h3 class="fw-bold mb-2">₹1,50,000</h3>
                <small class="text-danger fw-semibold"><i class="bi bi-arrow-down"></i> -5% from last month</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm card-dashboard">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 56px; height: 56px; background: linear-gradient(135deg, rgba(33, 150, 243, 0.1), rgba(3, 169, 244, 0.15)); box-shadow: 0 4px 12px rgba(33, 150, 243, 0.2);">
                        <i class="bi bi-cash-stack fs-4" style="color: #2196f3;"></i>
                    </div>
                </div>
                <h6 class="text-muted small fw-semibold mb-2" style="letter-spacing: 1px;">NET PROFIT</h6>
                <h3 class="fw-bold mb-2">₹3,00,250</h3>
                <small class="text-success fw-semibold"><i class="bi bi-arrow-up"></i> +18% from last month</small>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm card-dashboard">
    <div class="card-body p-4">
        <h6 class="fw-bold mb-4">Available Reports</h6>
        <div class="list-group list-group-flush">
            <a href="#" class="list-group-item list-group-item-action border-0 px-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 40px; height: 40px; background: rgba(0, 200, 83, 0.1);">
                            <i class="bi bi-file-earmark-text" style="color: #00c853;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Sales Report</h6>
                            <small class="text-muted">Detailed sales analysis</small>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-primary shadow">
                        <i class="bi bi-download"></i> Download
                    </button>
                </div>
            </a>
            
            <a href="#" class="list-group-item list-group-item-action border-0 px-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 40px; height: 40px; background: rgba(255, 193, 7, 0.1);">
                            <i class="bi bi-file-earmark-bar-graph" style="color: #ffc107;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Purchase Report</h6>
                            <small class="text-muted">Purchase & inventory analysis</small>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-primary shadow">
                        <i class="bi bi-download"></i> Download
                    </button>
                </div>
            </a>
            
            <a href="#" class="list-group-item list-group-item-action border-0 px-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 40px; height: 40px; background: rgba(33, 150, 243, 0.1);">
                            <i class="bi bi-file-earmark-spreadsheet" style="color: #2196f3;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Financial Summary</h6>
                            <small class="text-muted">Complete financial overview</small>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-primary shadow">
                        <i class="bi bi-download"></i> Download
                    </button>
                </div>
            </a>
        </div>
    </div>
</div>

@endsection
