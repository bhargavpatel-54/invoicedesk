@extends('layouts.app')

@section('title', 'Edit Customer / Vendor')

@section('content')

<div class="container-fluid">
    <!-- Page Header -->
    <div class="card border-0 shadow-sm card-dashboard mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        <i class="bi bi-pencil-square me-2"></i>Edit {{ ucfirst($customer->type) }}: {{ $customer->business_name }}
                    </h5>
                    <p class="text-muted small mb-0">Update the details below to modify the record</p>
                </div>
                <a href="{{ route('customers.index') }}" class="btn btn-white border shadow-sm btn-sm px-3">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm card-dashboard">
                <div class="card-body p-4">
                    <form action="{{ route('customers.update', $customer) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            <!-- Type Selection -->
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold mb-3 d-block text-muted small uppercase">Type Selection</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check custom-radio-box">
                                        <input class="form-check-input" type="radio" name="type" id="type_customer" value="customer" {{ (old('type') ?? $customer->type) == 'customer' ? 'checked' : '' }}>
                                        <label class="form-check-label px-4 py-3 rounded border w-100 text-center cursor-pointer" for="type_customer">
                                            <i class="bi bi-person me-2"></i>Customer
                                        </label>
                                    </div>
                                    <div class="form-check custom-radio-box">
                                        <input class="form-check-input" type="radio" name="type" id="type_vendor" value="vendor" {{ (old('type') ?? $customer->type) == 'vendor' ? 'checked' : '' }}>
                                        <label class="form-check-label px-4 py-3 rounded border w-100 text-center cursor-pointer" for="type_vendor">
                                            <i class="bi bi-shop me-2"></i>Vendor
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <hr class="mt-4 mb-2 opacity-25">

                            <!-- Basic Info -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-muted">Business Name *</label>
                                <input type="text" name="business_name" class="form-control" value="{{ old('business_name', $customer->business_name) }}" required placeholder="Enter business name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-muted">Contact Person *</label>
                                <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person', $customer->contact_person) }}" required placeholder="Enter contact person name">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold small text-muted">Phone *</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}" required placeholder="Primary phone number">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small text-muted">Alternate Phone</label>
                                <input type="text" name="alternate_phone" class="form-control" value="{{ old('alternate_phone', $customer->alternate_phone) }}" placeholder="Optional alternate numbers">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small text-muted">Email Address</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $customer->email) }}" placeholder="example@business.com">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-muted">GST Number</label>
                                <input type="text" name="gst_no" class="form-control" value="{{ old('gst_no', $customer->gst_no) }}" placeholder="e.g. 24XXXXX1234X1Z1">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-muted">PAN Number</label>
                                <input type="text" name="pan_no" class="form-control" value="{{ old('pan_no', $customer->pan_no) }}" placeholder="e.g. ABCDE1234F">
                            </div>

                            <hr class="mt-4 mb-2 opacity-25">

                            <!-- Address Info -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small text-muted">Address 1 *</label>
                                <input type="text" name="billing_address" class="form-control" value="{{ old('billing_address', $customer->billing_address) }}" required placeholder="Street address, area...">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small text-muted">Address 2</label>
                                <input type="text" name="address_2" class="form-control" value="{{ old('address_2', $customer->address_2) }}" placeholder="Building, Floor, etc.">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small text-muted">Landmark</label>
                                <input type="text" name="landmark" class="form-control" value="{{ old('landmark', $customer->landmark) }}" placeholder="Near by...">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small text-muted">City *</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city', $customer->city) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small text-muted">State *</label>
                                <input type="text" name="state" class="form-control" value="{{ old('state', $customer->state) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small text-muted">Pincode *</label>
                                <input type="text" name="pincode" class="form-control" value="{{ old('pincode', $customer->pincode) }}" required>
                            </div>

                            <hr class="mt-4 mb-2 opacity-25">

                            <!-- Financial Info -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small text-muted">Opening Balance</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">₹</span>
                                    <input type="number" step="0.01" name="opening_balance" class="form-control border-start-0" value="{{ old('opening_balance', $customer->opening_balance) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small text-muted">Balance Type</label>
                                <select name="balance_type" class="form-select">
                                    <option value="debit" {{ (old('balance_type') ?? $customer->balance_type) == 'debit' ? 'selected' : '' }}>Debit (Payable)</option>
                                    <option value="credit" {{ (old('balance_type') ?? $customer->balance_type) == 'credit' ? 'selected' : '' }}>Credit (Receivable)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small text-muted">Credit Limit</label>
                                <input type="number" name="credit_limit" class="form-control" value="{{ old('credit_limit', $customer->credit_limit) }}">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="form-label fw-semibold small text-muted">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $customer->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold text-dark" for="is_active">Active Account</label>
                                </div>
                            </div>

                            <div class="col-md-12 mt-4 text-end">
                                <a href="{{ route('customers.index') }}" class="btn btn-white border shadow-sm px-4 me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary text-white px-5 fw-bold shadow">
                                    <i class="bi bi-save me-2"></i>Update Record
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra-css')
<style>
    .custom-radio-box {
        flex: 1;
        position: relative;
        padding-left: 0;
    }
    .custom-radio-box .form-check-input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    .custom-radio-box .form-check-label {
        background: #fff;
        transition: all 0.2s;
        border: 2px solid #edf2f7 !important;
        color: #718096;
    }
    .custom-radio-box .form-check-input:checked + .form-check-label {
        border-color: #00c853 !important;
        background: rgba(0, 200, 83, 0.05);
        color: #00c853;
        font-weight: 600;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .form-control:focus, .form-select:focus {
        border-color: #00c853;
        box-shadow: 0 0 0 0.2rem rgba(0, 200, 83, 0.15);
    }
</style>
@endsection
