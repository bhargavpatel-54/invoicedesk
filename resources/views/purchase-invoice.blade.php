@extends('layouts.app')

@section('title', 'Purchase Invoice')

@section('content')

<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="mb-2 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-cart-fill me-2"></i>Purchase Invoice Management
                </h5>
                <div class="d-flex gap-4 mt-2 small text-muted">
                    <span><i class="bi bi-circle-fill text-success me-1" style="font-size: 8px;"></i>Paid: <b class="text-dark">25</b></span>
                    <span><i class="bi bi-circle-fill text-warning me-1" style="font-size: 8px;"></i>Pending: <b class="text-dark">10</b></span>
                    <span><i class="bi bi-circle-fill text-danger me-1" style="font-size: 8px;"></i>Overdue: <b class="text-dark">3</b></span>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-white border shadow-sm btn-sm"><i class="bi bi-funnel me-1"></i> Filter</button>
                <button class="btn btn-primary text-white btn-sm px-3 fw-semibold shadow"><i class="bi bi-plus-lg me-1"></i> New Invoice</button>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm card-dashboard">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge rounded-pill px-3 py-2" style="background: linear-gradient(135deg, rgba(0, 200, 83, 0.15), rgba(0, 230, 118, 0.15)); color: #00c853; font-weight: 600;">Paid</span>
                    <small class="text-muted">#INV-001</small>
                </div>
                <h6 class="fw-bold mb-2">Akash Nutbolt</h6>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted small">Amount:</span>
                    <span class="fw-bold">₹45,000</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted small">Date:</span>
                    <span class="text-muted">21 Jan 2026</span>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-white border shadow-sm flex-fill"><i class="bi bi-eye"></i> View</button>
                    <button class="btn btn-sm btn-primary shadow"><i class="bi bi-printer"></i></button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm card-dashboard">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge rounded-pill px-3 py-2" style="background: linear-gradient(135deg, rgba(255, 193, 7, 0.15), rgba(255, 179, 0, 0.15)); color: #ffc107; font-weight: 600;">Pending</span>
                    <small class="text-muted">#INV-002</small>
                </div>
                <h6 class="fw-bold mb-2">Anky Industries</h6>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted small">Amount:</span>
                    <span class="fw-bold">₹32,500</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted small">Due:</span>
                    <span class="text-warning">25 Jan 2026</span>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-white border shadow-sm flex-fill"><i class="bi bi-eye"></i> View</button>
                    <button class="btn btn-sm btn-primary shadow"><i class= "bi bi-printer"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
