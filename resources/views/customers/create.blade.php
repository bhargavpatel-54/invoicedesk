@extends('layouts.app')

@section('title', 'Add New Record')

@section('content')

<!-- Page Header -->
<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <!-- Desktop Header -->
        <div class="d-none d-md-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="mb-1 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-person-plus-fill me-2"></i>Add Customer / Vendor
                </h5>
                <p class="text-muted small mb-0">Create a new profile for your business connections.</p>
            </div>
            <a href="{{ route('customers.index') }}" class="btn btn-white border shadow-sm btn-sm px-3">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <!-- Mobile Header -->
        <div class="d-md-none text-center">
            <h5 class="mb-3 fw-bold">New Record</h5>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('customers.index') }}" class="btn btn-white border shadow-sm btn-sm w-100">
                    <i class="bi bi-arrow-left me-1"></i> Cancel
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm card-dashboard">
    <div class="card-body p-4">
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-4">
                <!-- Type Selection -->
                <div class="col-12 text-center text-md-start mb-2">
                    <label class="fw-bold mb-3 d-block text-muted extra-small uppercase">Engagement Type</label>
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3">
                        <div class="custom-radio-box flex-fill flex-md-initial" style="min-width: 150px;">
                            <input class="form-check-input" type="radio" name="type" id="type_customer" value="customer" checked {{ old('type') == 'customer' ? 'checked' : '' }}>
                            <label class="form-check-label px-4 py-3 rounded-3 border w-100 text-center cursor-pointer shadow-sm" for="type_customer">
                                <i class="bi bi-person me-2"></i>Customer
                            </label>
                        </div>
                        <div class="custom-radio-box flex-fill flex-md-initial" style="min-width: 150px;">
                            <input class="form-check-input" type="radio" name="type" id="type_vendor" value="vendor" {{ old('type') == 'vendor' ? 'checked' : '' }}>
                            <label class="form-check-label px-4 py-3 rounded-3 border w-100 text-center cursor-pointer shadow-sm" for="type_vendor">
                                <i class="bi bi-shop me-2"></i>Vendor
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-12"><hr class="my-0 opacity-25"></div>

                <!-- Basic Info -->
                <div class="col-md-6">
                    <label class="form-label fw-bold small text-muted uppercase">Business Name *</label>
                    <input type="text" name="business_name" class="form-control" value="{{ old('business_name') }}" required placeholder="e.g. Acme Corp">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small text-muted uppercase">Contact Person *</label>
                    <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person') }}" required placeholder="e.g. John Doe">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted uppercase">Phone *</label>
                    <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" required placeholder="10-digit number">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted uppercase">Alt Phone</label>
                    <input type="tel" name="alternate_phone" class="form-control" value="{{ old('alternate_phone') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted uppercase">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="billing@domain.com">
                </div>

                <div class="col-6 col-md-6">
                    <label class="form-label fw-bold small text-muted uppercase">GSTIN</label>
                    <input type="text" name="gst_no" class="form-control uppercase" value="{{ old('gst_no') }}" placeholder="GST Registration #">
                </div>
                <div class="col-6 col-md-6">
                    <label class="form-label fw-bold small text-muted uppercase">PAN Number</label>
                    <input type="text" name="pan_no" class="form-control uppercase" value="{{ old('pan_no') }}">
                </div>

                <div class="col-12"><hr class="my-0 opacity-25"></div>

                <!-- Address Info -->
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted uppercase">Street Address *</label>
                    <input type="text" name="billing_address" class="form-control" value="{{ old('billing_address') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted uppercase">Area / Building</label>
                    <input type="text" name="address_2" class="form-control" value="{{ old('address_2') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted uppercase">Landmark</label>
                    <input type="text" name="landmark" class="form-control" value="{{ old('landmark') }}">
                </div>
                <div class="col-4 col-md-4">
                    <label class="form-label fw-bold small text-muted uppercase">City *</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
                </div>
                <div class="col-4 col-md-4">
                    <label class="form-label fw-bold small text-muted uppercase">State *</label>
                    <input type="text" name="state" class="form-control" value="{{ old('state', 'Gujarat') }}" required>
                </div>
                <div class="col-4 col-md-4">
                    <label class="form-label fw-bold small text-muted uppercase">Pincode *</label>
                    <input type="text" name="pincode" class="form-control" value="{{ old('pincode') }}" required>
                </div>

                <div class="col-12"><hr class="my-0 opacity-25"></div>

                <!-- Financial Info -->
                <div class="col-6 col-md-4">
                    <label class="form-label fw-bold small text-muted uppercase">Opening Balance</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0 bg-light fw-bold small">₹</span>
                        <input type="number" step="0.01" name="opening_balance" class="form-control" value="{{ old('opening_balance', 0) }}">
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <label class="form-label fw-bold small text-muted uppercase">Balance Type</label>
                    <select name="balance_type" class="form-select">
                        <option value="debit" {{ old('balance_type') == 'debit' ? 'selected' : '' }}>Debit (Payable)</option>
                        <option value="credit" {{ old('balance_type') == 'credit' ? 'selected' : '' }}>Credit (Receivable)</option>
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label fw-bold small text-muted uppercase">Credit limit</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0 bg-light fw-bold small">₹</span>
                        <input type="number" name="credit_limit" class="form-control" value="{{ old('credit_limit', 0) }}">
                    </div>
                </div>

                <div class="col-12 mt-5">
                    <div class="d-flex flex-column flex-md-row gap-2 justify-content-md-end">
                        <button type="reset" class="btn btn-white border px-4 py-2 order-2 order-md-1">Clear Form</button>
                        <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow order-1 order-md-2">
                            <i class="bi bi-save-fill me-2"></i>SAVE RECORD
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
    .extra-small { font-size: 11px; }
    .btn-white { background: #fff; color: #1a202c; }
    
    .custom-radio-box {
        position: relative;
    }
    .custom-radio-box .form-check-input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
        z-index: 10;
        margin: 0;
    }
    .custom-radio-box .form-check-label {
        background: #fff;
        transition: all 0.2s;
        border: 2px solid #edf2f7 !important;
        color: #718096;
        display: block;
    }
    .custom-radio-box .form-check-input:checked + .form-check-label {
        border-color: #00c853 !important;
        background: rgba(0, 200, 83, 0.05);
        color: #00c853;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(0, 200, 83, 0.1) !important;
    }
</style>

@endsection
