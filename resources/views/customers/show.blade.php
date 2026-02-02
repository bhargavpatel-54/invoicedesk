@extends('layouts.app')

@section('title', 'View Customer / Vendor')

@section('content')

<!-- Page Header -->
<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <!-- Desktop Header -->
        <div class="d-none d-md-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10" style="width: 56px; height: 56px;">
                    <i class="bi bi-person-vcard fs-4 text-primary"></i>
                </div>
                <div>
                    <h5 class="mb-1 fw-bold text-dark">{{ $customer->business_name }}</h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge rounded-pill px-3 py-1 extra-small" style="background: {{ $customer->type == 'customer' ? 'rgba(0, 200, 83, 0.15)' : 'rgba(255, 193, 7, 0.15)' }}; color: {{ $customer->type == 'customer' ? '#00c853' : '#ffc107' }};">
                            {{ ucfirst($customer->type) }}
                        </span>
                        <span class="text-muted small">Contact: {{ $customer->contact_person }}</span>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('customers.index') }}" class="btn btn-white border shadow-sm btn-sm px-3">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary btn-sm px-4 shadow">
                    <i class="bi bi-pencil me-2"></i>Edit Profile
                </a>
            </div>
        </div>

        <!-- Mobile Header -->
        <div class="d-md-none text-center">
            <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10 mx-auto mb-3" style="width: 64px; height: 64px;">
                <i class="bi bi-person-vcard fs-3 text-primary"></i>
            </div>
            <h5 class="fw-bold mb-1">{{ $customer->business_name }}</h5>
            <div class="mb-3">
                <span class="badge rounded-pill px-3 py-1 extra-small" style="background: {{ $customer->type == 'customer' ? 'rgba(0, 200, 83, 0.15)' : 'rgba(255, 193, 7, 0.15)' }}; color: {{ $customer->type == 'customer' ? '#00c853' : '#ffc107' }};">
                    {{ ucfirst($customer->type) }}
                </span>
            </div>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('customers.index') }}" class="btn btn-white border shadow-sm btn-sm">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary btn-sm px-4 shadow flex-fill">
                    <i class="bi bi-pencil me-2"></i>Edit
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Details Card -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm card-dashboard h-100">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="mb-0 fw-bold text-muted small uppercase">Profile Information</h6>
            </div>
            <div class="card-body p-4 pt-0">
                <div class="row g-4 text-start">
                    <div class="col-6">
                        <label class="d-block text-muted extra-small uppercase fw-bold mb-1">Phone Number</label>
                        <p class="fw-semibold text-dark small">{{ $customer->phone }}</p>
                    </div>
                    <div class="col-6">
                        <label class="d-block text-muted extra-small uppercase fw-bold mb-1">Email Address</label>
                        <p class="fw-semibold text-dark small text-truncate">{{ $customer->email ?? 'N/A' }}</p>
                    </div>
                    <div class="col-6">
                        <label class="d-block text-muted extra-small uppercase fw-bold mb-1">GST Number</label>
                        <p class="fw-bold text-primary small">{{ $customer->gst_no ?? 'N/A' }}</p>
                    </div>
                    <div class="col-6">
                        <label class="d-block text-muted extra-small uppercase fw-bold mb-1">PAN Number</label>
                        <p class="fw-semibold text-dark small">{{ $customer->pan_no ?? 'N/A' }}</p>
                    </div>
                    <div class="col-12">
                        <hr class="my-2 opacity-25">
                        <label class="d-block text-muted extra-small uppercase fw-bold mb-1 mt-3">Billing Address</label>
                        <div class="bg-light p-3 rounded-3 mt-2">
                            <p class="fw-semibold text-dark mb-1">{{ $customer->billing_address }}</p>
                            @if($customer->address_2)
                                <p class="fw-semibold text-dark mb-1">{{ $customer->address_2 }}</p>
                            @endif
                            @if($customer->landmark)
                                <p class="text-muted small mb-1">Landmark: {{ $customer->landmark }}</p>
                            @endif
                            <p class="text-muted small mb-0">{{ $customer->city }}, {{ $customer->state }} - {{ $customer->pincode }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary stats -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm card-dashboard h-100">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="mb-0 fw-bold text-muted small uppercase">Account Summary</h6>
            </div>
            <div class="card-body p-4 pt-0">
                <div class="p-4 rounded-4 bg-light mb-4 text-center">
                    <label class="d-block text-muted extra-small fw-bold mb-2 uppercase">Current Balance</label>
                    <h3 class="fw-bold mb-0 {{ $customer->getCurrentBalance() > 0 ? 'text-success' : 'text-danger' }}">
                        ₹ {{ number_format(abs($customer->getCurrentBalance()), 2) }}
                        <small class="fs-6 fw-normal text-muted">{{ $customer->balance_type == 'credit' ? 'Cr' : 'Dr' }}</small>
                    </h3>
                </div>

                <div class="list-group list-group-flush small">
                    <div class="list-group-item d-flex justify-content-between px-0 py-3 bg-transparent border-dashed">
                        <span class="text-muted">Credit Limit</span>
                        <span class="fw-bold text-dark">₹ {{ number_format($customer->credit_limit, 2) }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0 py-3 bg-transparent border-dashed">
                        <span class="text-muted">Credit Period</span>
                        <span class="fw-bold text-dark">{{ $customer->credit_days ?? 0 }} Days</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0 py-3 bg-transparent border-0">
                        <span class="text-muted">Account Status</span>
                        <span class="badge {{ $customer->is_active ? 'bg-success' : 'bg-danger' }} bg-opacity-10 text-{{ $customer->is_active ? 'success' : 'danger' }} rounded-pill px-3">
                            {{ $customer->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
    .extra-small { font-size: 11px; }
    .btn-white { background: #fff; color: #1a202c; }
    .btn-white:hover { background: #f8f9fa; color: #1a202c; }
    .border-dashed { border-bottom-style: dashed !important; }
</style>

@endsection
