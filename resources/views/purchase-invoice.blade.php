@extends('layouts.app')

@section('title', 'Purchase Invoices')

@section('content')

<!-- Page Header -->
<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <!-- Desktop Header (Big Screen Only) -->
        <div class="d-none d-md-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="mb-2 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-cart-fill me-2"></i>Purchase Invoices
                </h5>
                <div class="d-flex gap-4 mt-2 small text-muted">
                    <span><i class="bi bi-circle-fill text-success me-1" style="font-size: 8px;"></i>Paid Total: <b class="text-dark">₹ 14.5L</b></span>
                    <span><i class="bi bi-circle-fill text-warning me-1" style="font-size: 8px;"></i>Pending: <b class="text-dark">₹ 2.8L</b></span>
                    <span><i class="bi bi-circle-fill text-danger me-1" style="font-size: 8px;"></i>Overdue: <b class="text-dark">₹ 45k</b></span>
                </div>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <div class="d-flex gap-1 mb-0">
                    <input type="text" class="form-control form-control-sm" placeholder="Search invoices..." style="width: 150px;">
                    <select class="form-select form-select-sm" style="width: 120px;">
                        <option value="">All Status</option>
                        <option value="paid">Paid</option>
                        <option value="pending">Pending</option>
                        <option value="overdue">Overdue</option>
                    </select>
                    <button type="button" class="btn btn-white border shadow-sm btn-sm">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                <button class="btn btn-success text-white btn-sm px-3 fw-semibold shadow">
                    <i class="bi bi-plus-lg me-1"></i> New Purchase
                </button>
            </div>
        </div>

        <!-- Mobile Header (Small Screen Only) -->
        <div class="d-md-none">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-cart-fill me-2"></i>Purchase
                </h5>
                <button class="btn btn-success text-white btn-sm px-3 fw-semibold shadow">
                    <i class="bi bi-plus-lg me-1"></i> New
                </button>
            </div>
            <div class="d-flex gap-1 mb-3">
                <input type="text" class="form-control form-control-sm flex-grow-1" placeholder="Search...">
                <button type="button" class="btn btn-white border shadow-sm btn-sm">
                    <i class="bi bi-search"></i>
                </button>
                <button type="button" class="btn btn-white border shadow-sm btn-sm">
                    <i class="bi bi-funnel"></i>
                </button>
            </div>
            <div class="row g-2 text-center">
                <div class="col-4">
                    <div class="bg-light p-2 rounded-3">
                        <small class="text-muted d-block">Paid</small>
                        <b class="text-success small">14.5L</b>
                    </div>
                </div>
                <div class="col-4">
                    <div class="bg-light p-2 rounded-3">
                        <small class="text-muted d-block">Pend</small>
                        <b class="text-warning small">2.8L</b>
                    </div>
                </div>
                <div class="col-4">
                    <div class="bg-light p-2 rounded-3">
                        <small class="text-muted d-block">Over</small>
                        <b class="text-danger small">45k</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Purchase Invoices Table -->
<div class="card border-0 shadow-sm card-dashboard">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light d-none d-md-table-header-group">
                <tr>
                    <th class="border-0 px-4 py-3 small text-muted uppercase fw-bold">Purchase #</th>
                    <th class="border-0 py-3 small text-muted uppercase fw-bold">Vendor</th>
                    <th class="border-0 py-3 small text-muted uppercase fw-bold">Date</th>
                    <th class="border-0 py-3 small text-muted uppercase fw-bold text-end">Amount</th>
                    <th class="border-0 py-3 small text-muted uppercase fw-bold text-center">Status</th>
                    <th class="border-0 px-4 py-3 small text-muted uppercase fw-bold text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dummy Row 1 -->
                <tr class="invoice-row d-none d-md-table-row">
                    <td class="px-4">
                        <a href="#" class="fw-bold text-success text-decoration-none">PRCH-0042</a>
                        <small class="d-block text-muted">Bill: B-10293</small>
                    </td>
                    <td>
                        <div class="fw-medium text-dark">Akash Nutbolt</div>
                        <small class="text-muted">+91 98765 43210</small>
                    </td>
                    <td>
                        <div class="text-dark small">28 Jan 2026</div>
                        <small class="text-muted" style="font-size: 10px;">Due: 15 Feb 2026</small>
                    </td>
                    <td class="text-end fw-bold text-dark">₹ 45,000.00</td>
                    <td class="text-center">
                        <span class="badge bg-success rounded-pill px-3 py-1 fw-medium uppercase" style="font-size: 10px;">Paid</span>
                    </td>
                    <td class="px-4 text-end">
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i> View Bill</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-pdf me-2"></i> PDF</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i> Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>

                <!-- Dummy Row 2 -->
                <tr class="invoice-row d-none d-md-table-row">
                    <td class="px-4">
                        <a href="#" class="fw-bold text-success text-decoration-none">PRCH-0041</a>
                        <small class="d-block text-muted">Bill: ANKY-29</small>
                    </td>
                    <td>
                        <div class="fw-medium text-dark">Anky Industries</div>
                        <small class="text-muted">+91 88888 77777</small>
                    </td>
                    <td>
                        <div class="text-dark small">25 Jan 2026</div>
                        <small class="text-muted" style="font-size: 10px;">Due: 25 Jan 2026</small>
                    </td>
                    <td class="text-end fw-bold text-dark">₹ 32,500.00</td>
                    <td class="text-center">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-1 fw-medium uppercase" style="font-size: 10px;">Pending</span>
                            <button class="btn btn-success btn-sm rounded-pill px-3 py-1" style="font-size: 10px;">
                                <i class="bi bi-check-circle me-1"></i> Mark Paid
                            </button>
                        </div>
                    </td>
                    <td class="px-4 text-end">
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i> View Bill</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i> Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>

                <!-- Mobile View -->
                <tr class="d-md-none">
                    <td colspan="6" class="p-0">
                        <div class="p-3 border-bottom mobile-card">
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <span class="fw-bold text-success">PRCH-0042</span>
                                    <div class="small fw-medium">Akash Nutbolt</div>
                                </div>
                                <span class="badge bg-success rounded-pill px-2 py-1" style="font-size: 9px;">PAID</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">28 Jan 2026</small>
                                <div class="fw-bold">₹ 45,000.00</div>
                            </div>
                        </div>
                        <div class="p-3 border-bottom mobile-card">
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <span class="fw-bold text-success">PRCH-0041</span>
                                    <div class="small fw-medium">Anky Industries</div>
                                </div>
                                <span class="badge bg-warning text-dark rounded-pill px-2 py-1" style="font-size: 9px;">PENDING</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">25 Jan 2026</small>
                                <div class="fw-bold">₹ 32,500.00</div>
                            </div>
                            <div class="mt-2 text-end">
                                <button class="btn btn-success btn-sm rounded-pill px-3 py-1" style="font-size: 10px;">Mark Paid</button>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white border-0 py-4 text-center">
        <p class="text-muted small mb-0">Showing 2 records (Dummy Data)</p>
    </div>
</div>

<style>
    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
    .card-dashboard { border-radius: 12px; }
    .btn-white { background: #fff; color: #1a202c; }
    .mobile-card { transition: background 0.2s; }
    .mobile-card:active { background: #f8f9fa; }
    
    .table-responsive { 
        overflow: visible !important;
        min-height: 400px;
    }
    
    .dropdown-menu { 
        z-index: 1060;
        border: none !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
        border-radius: 10px !important;
    }
</style>

@endsection
