@extends('layouts.app')

@section('title', 'Expense & Income')

@section('content')

<!-- Page Header -->
<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <!-- Desktop Header (Big Screen Only) -->
        <div class="d-none d-md-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="mb-2 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-wallet2 me-2"></i>Expense & Income Tracking
                </h5>
                <div class="d-flex gap-4 mt-2 small text-muted">
                    <span><i class="bi bi-circle-fill text-success me-1" style="font-size: 8px;"></i>Income: <b class="text-dark">₹5,00,000</b></span>
                    <span><i class="bi bi-circle-fill text-danger me-1" style="font-size: 8px;"></i>Expense: <b class="text-dark">₹2,00,000</b></span>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-white border shadow-sm btn-sm"><i class="bi bi-funnel me-1"></i> Filter</button>
                <button class="btn btn-primary text-white btn-sm px-3 fw-semibold shadow"><i class="bi bi-plus-lg me-1"></i> Add Entry</button>
            </div>
        </div>

        <!-- Mobile Header (Small Screen Only) -->
        <div class="d-md-none">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-wallet2 me-2"></i>Cash Flow
                </h5>
                <button class="btn btn-primary text-white btn-sm px-3 fw-semibold shadow"><i class="bi bi-plus-lg"></i></button>
            </div>
            <div class="d-flex justify-content-around small text-muted bg-light p-2 rounded-3 mt-2">
                <span>In: <b class="text-success">₹5.0L</b></span>
                <span>Out: <b class="text-danger">₹2.0L</b></span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm card-dashboard h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">Recent Income</h6>
                    <span class="badge rounded-pill px-3 py-2" style="background: linear-gradient(135deg, rgba(0, 200, 83, 0.15), rgba(0, 230, 118, 0.15)); color: #00c853; font-weight: 600;">This Month</span>
                </div>
                <div class="mb-3 pb-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Sales Revenue</h6>
                            <small class="text-muted">21 Jan 2026</small>
                        </div>
                        <h5 class="mb-0 text-success fw-bold">+₹4,50,000</h5>
                    </div>
                </div>
                <div class="mb-3 pb-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Service Income</h6>
                            <small class="text-muted">20 Jan 2026</small>
                        </div>
                        <h5 class="mb-0 text-success fw-bold">+₹50,000</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card border-0 shadow-sm card-dashboard h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">Recent Expenses</h6>
                    <span class="badge rounded-pill px-3 py-2" style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.15), rgba(255, 0, 0, 0.1)); color: #dc3545; font-weight: 600;">This Month</span>
                </div>
                <div class="mb-3 pb-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Raw Material Purchase</h6>
                            <small class="text-muted">19 Jan 2026</small>
                        </div>
                        <h5 class="mb-0 text-danger fw-bold">-₹1,50,000</h5>
                    </div>
                </div>
                <div class="mb-3 pb-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Office Rent</h6>
                            <small class="text-muted">18 Jan 2026</small>
                        </div>
                        <h5 class="mb-0 text-danger fw-bold">-₹50,000</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
