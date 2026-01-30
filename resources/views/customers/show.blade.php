@extends('layouts.app')

@section('title', 'View Customer / Vendor')

@section('content')

<div class="container-fluid">
    <!-- Page Header -->
    <div class="card border-0 shadow-sm card-dashboard mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                        <i class="bi bi-person-vcard fs-3 text-primary"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold">{{ $customer->business_name }}</h5>
                        <p class="text-muted small mb-0">
                            <span class="badge rounded-pill px-3 py-1 me-2" style="background: {{ $customer->type == 'customer' ? 'rgba(0, 200, 83, 0.15)' : 'rgba(255, 193, 7, 0.15)' }}; color: {{ $customer->type == 'customer' ? '#00c853' : '#ffc107' }};">
                                {{ ucfirst($customer->type) }}
                            </span>
                            Contact: {{ $customer->contact_person }}
                        </p>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-white border shadow-sm btn-sm px-3">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </a>
                    <a href="{{ route('customers.index') }}" class="btn btn-white border shadow-sm btn-sm px-3">
                        <i class="bi bi-arrow-left me-1"></i> Back
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
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="d-block text-muted extra-small uppercase fw-bold mb-1">Phone Number</label>
                            <p class="fw-semibold">{{ $customer->phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="d-block text-muted extra-small uppercase fw-bold mb-1">Email Address</label>
                            <p class="fw-semibold">{{ $customer->email ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="d-block text-muted extra-small uppercase fw-bold mb-1">GST Number</label>
                            <p class="fw-semibold text-primary">{{ $customer->gst_no ?? 'Not Registered' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="d-block text-muted extra-small uppercase fw-bold mb-1">PAN Number</label>
                            <p class="fw-semibold">{{ $customer->pan_no ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-12">
                            <label class="d-block text-muted extra-small uppercase fw-bold mb-1">Address</label>
                            <p class="fw-semibold mb-1">{{ $customer->billing_address }}</p>
                            @if($customer->address_2)
                                <p class="fw-semibold mb-1">{{ $customer->address_2 }}</p>
                            @endif
                            @if($customer->landmark)
                                <p class="text-muted small mb-1">Landmark: {{ $customer->landmark }}</p>
                            @endif
                            <p class="text-muted small">{{ $customer->city }}, {{ $customer->state }} - {{ $customer->pincode }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- summary stats -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm card-dashboard h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="mb-0 fw-bold text-muted small uppercase">Account Summary</h6>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="p-4 rounded-4 bg-light mb-4">
                        <label class="d-block text-muted small fw-bold mb-2">Current Balance</label>
                        <h3 class="fw-bold mb-0 {{ $customer->getCurrentBalance() > 0 ? 'text-success' : 'text-danger' }}">
                            ₹ {{ number_format(abs($customer->getCurrentBalance()), 2) }}
                            <small class="fs-6 fw-normal text-muted">{{ $customer->balance_type == 'credit' ? 'Cr' : 'Dr' }}</small>
                        </h3>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted small">Credit Limit</span>
                        <span class="fw-bold">₹ {{ number_format($customer->credit_limit, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted small">Credit Days</span>
                        <span class="fw-bold">{{ $customer->credit_days ?? 0 }} Days</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">Status</span>
                        <span class="badge {{ $customer->is_active ? 'bg-success' : 'bg-danger' }} bg-opacity-10 text-{{ $customer->is_active ? 'success' : 'danger' }} px-3">
                            {{ $customer->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Invoices section can be added here later -->
    </div>
</div>

@endsection

@section('extra-css')
<style>
    .extra-small {
        font-size: 11px;
    }
    .uppercase {
        letter-spacing: 0.5px;
    }
</style>
@endsection
