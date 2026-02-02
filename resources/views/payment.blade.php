@extends('layouts.app')

@section('title', 'Payment')

@section('content')

<!-- Page Header -->
<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <!-- Desktop Header (Big Screen Only) -->
        <div class="d-none d-md-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="mb-2 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-currency-rupee me-2"></i>Payment Management
                </h5>
                <div class="d-flex gap-4 mt-2 small text-muted">
                    <span><i class="bi bi-circle-fill text-success me-1" style="font-size: 8px;"></i>Received: <b class="text-dark">₹4,50,000</b></span>
                    <span><i class="bi bi-circle-fill text-danger me-1" style="font-size: 8px;"></i>Paid: <b class="text-dark">₹1,50,000</b></span>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-white border shadow-sm btn-sm"><i class="bi bi-funnel me-1"></i> Filter</button>
                <button class="btn btn-primary text-white btn-sm px-3 fw-semibold shadow"><i class="bi bi-plus-lg me-1"></i> Record Payment</button>
            </div>
        </div>

        <!-- Mobile Header (Small Screen Only) -->
        <div class="d-md-none">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-currency-rupee me-2"></i>Payments
                </h5>
                <button class="btn btn-primary text-white btn-sm px-3 fw-semibold shadow"><i class="bi bi-plus-lg"></i></button>
            </div>
            <div class="d-flex justify-content-around small text-muted bg-light p-2 rounded-3 mt-2">
                <span>Recv: <b class="text-success">₹4.5L</b></span>
                <span>Paid: <b class="text-danger">₹1.5L</b></span>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm card-dashboard">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light d-none d-md-table-header-group">
                <tr>
                    <th class="ps-4 py-3 small text-muted uppercase fw-bold">Date</th>
                    <th class="py-3 small text-muted uppercase fw-bold">Party Name</th>
                    <th class="py-3 small text-muted uppercase fw-bold">Type</th>
                    <th class="py-3 small text-muted uppercase fw-bold text-end">Amount</th>
                    <th class="py-3 small text-muted uppercase fw-bold">Mode</th>
                    <th class="text-end pe-4 py-3 small text-muted uppercase fw-bold">Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Desktop Row 1 -->
                <tr class="d-none d-md-table-row">
                    <td class="ps-4 text-dark small">21 Jan 2026</td>
                    <td class="fw-bold text-dark">Akash Nutbolt</td>
                    <td><span class="badge rounded-pill px-3 py-1 fw-medium" style="background: rgba(0, 200, 83, 0.1); color: #00c853; font-size: 10px;">RECEIVED</span></td>
                    <td class="text-end fw-bold text-success">+₹45,000</td>
                    <td class="text-muted small">UPI</td>
                    <td class="text-end pe-4">
                        <button class="btn btn-light btn-sm rounded-circle"><i class="bi bi-eye"></i></button>
                    </td>
                </tr>
                <!-- Mobile Card 1 -->
                <tr class="d-md-none">
                    <td colspan="6" class="p-0">
                        <div class="p-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="fw-bold text-dark">Akash Nutbolt</div>
                                    <div class="extra-small text-muted">21 Jan 2026 • UPI</div>
                                </div>
                                <span class="badge rounded-pill px-2 py-1 fw-medium" style="background: rgba(0, 200, 83, 0.1); color: #00c853; font-size: 9px;">RECEIVED</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-success">+₹45,000</span>
                                <button class="btn btn-light btn-sm rounded-pill px-3 py-1" style="font-size: 10px;">View</button>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Desktop Row 2 -->
                <tr class="d-none d-md-table-row">
                    <td class="ps-4 text-dark small">20 Jan 2026</td>
                    <td class="fw-bold text-dark">Steel Suppliers Co.</td>
                    <td><span class="badge rounded-pill px-3 py-1 fw-medium" style="background: rgba(220, 53, 69, 0.1); color: #dc3545; font-size: 10px;">PAID</span></td>
                    <td class="text-end fw-bold text-danger">-₹25,000</td>
                    <td class="text-muted small">Bank Transfer</td>
                    <td class="text-end pe-4">
                        <button class="btn btn-light btn-sm rounded-circle"><i class="bi bi-eye"></i></button>
                    </td>
                </tr>
                <!-- Mobile Card 2 -->
                <tr class="d-md-none">
                    <td colspan="6" class="p-0">
                        <div class="p-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="fw-bold text-dark">Steel Suppliers Co.</div>
                                    <div class="extra-small text-muted">20 Jan 2026 • Bank</div>
                                </div>
                                <span class="badge rounded-pill px-2 py-1 fw-medium" style="background: rgba(220, 53, 69, 0.1); color: #dc3545; font-size: 9px;">PAID</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-danger">-₹25,000</span>
                                <button class="btn btn-light btn-sm rounded-pill px-3 py-1" style="font-size: 10px;">View</button>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style>
    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
    .card-dashboard { border-radius: 12px; }
    .extra-small { font-size: 11px; }
    @media (max-width: 768px) {
        .card-body.p-4 { padding: 1.25rem !important; }
    }
</style>

@endsection
