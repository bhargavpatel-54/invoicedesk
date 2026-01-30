@extends('layouts.app')

@section('title', 'Payment')

@section('content')

<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
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
    </div>
</div>

<div class="card border-0 shadow-sm card-dashboard">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light fs-7 text-muted">
                <tr>
                    <th class="ps-4 fw-semibold">Date</th>
                    <th class="fw-semibold">Party Name</th>
                    <th class="fw-semibold">Type</th>
                    <th class="fw-semibold text-end">Amount</th>
                    <th class="fw-semibold">Mode</th>
                    <th class="text-end pe-4 fw-semibold">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="ps-4 text-muted">21 Jan 2026</td>
                    <td class="fw-semibold">Akash Nutbolt</td>
                    <td><span class="badge rounded-pill px-3 py-2" style="background: linear-gradient(135deg, rgba(0, 200, 83, 0.15), rgba(0, 230, 118, 0.15)); color: #00c853; font-weight: 600;">Received</span></td>
                    <td class="text-end fw-bold text-success">+₹45,000</td>
                    <td class="text-muted">UPI</td>
                    <td class="text-end pe-4">
                        <button class="btn btn-sm btn-white border shadow-sm"><i class="bi bi-eye"></i> View</button>
                    </td>
                </tr>
                <tr>
                    <td class="ps-4 text-muted">20 Jan 2026</td>
                    <td class="fw-semibold">Steel Suppliers Co.</td>
                    <td><span class="badge rounded-pill px-3 py-2" style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.15), rgba(255, 0, 0, 0.1)); color: #dc3545; font-weight: 600;">Paid</span></td>
                    <td class="text-end fw-bold text-danger">-₹25,000</td>
                    <td class="text-muted">Bank Transfer</td>
                    <td class="text-end pe-4">
                        <button class="btn btn-sm btn-white border shadow-sm"><i class="bi bi-eye"></i> View</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
