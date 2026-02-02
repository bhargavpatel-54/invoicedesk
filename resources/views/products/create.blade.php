@extends('layouts.app')

@section('title', 'Add New Product')

@section('content')

<!-- Page Header -->
<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <!-- Desktop Header -->
        <div class="d-none d-md-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="mb-1 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #3b82f6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-box-seam-fill me-2"></i>Add New Product
                </h5>
                <p class="text-muted small mb-0">Define product details, pricing, and initial stock levels.</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-white border shadow-sm btn-sm px-3">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <!-- Mobile Header -->
        <div class="d-md-none text-center">
            <h5 class="mb-3 fw-bold">Add Product</h5>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('products.index') }}" class="btn btn-white border shadow-sm btn-sm w-100">
                    <i class="bi bi-arrow-left me-1"></i> Cancel
                </a>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('products.store') }}" method="POST">
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
        <!-- Basic Info -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm card-dashboard h-100">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4 d-flex align-items-center uppercase extra-small text-muted">
                        <i class="bi bi-info-circle me-2 text-primary"></i> Basic Information
                    </h6>
                    
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-muted uppercase">Product Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. SS Washer 12mm">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted uppercase">Category</label>
                            <input type="text" name="category" class="form-control" value="{{ old('category') }}" placeholder="e.g. Hardware">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted uppercase">Brand</label>
                            <input type="text" name="brand" class="form-control" value="{{ old('brand') }}" placeholder="e.g. Shakti">
                        </div>

                        <div class="col-6 col-md-4">
                            <label class="form-label fw-bold small text-muted uppercase">Code</label>
                            <input type="text" name="product_code" class="form-control @error('product_code') is-invalid @enderror" value="{{ old('product_code') }}">
                        </div>

                        <div class="col-6 col-md-4">
                            <label class="form-label fw-bold small text-muted uppercase">SKU</label>
                            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku') }}">
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label fw-bold small text-muted uppercase">HSN/SAC Code</label>
                            <input type="text" name="hsn_code" class="form-control" value="{{ old('hsn_code') }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted uppercase">Description</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Brief details about the product...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing & Stock -->
        <div class="col-lg-4">
            <!-- Pricing Card -->
            <div class="card border-0 shadow-sm card-dashboard mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4 d-flex align-items-center uppercase extra-small text-muted">
                        <i class="bi bi-currency-rupee me-2 text-primary"></i> Pricing & Tax
                    </h6>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted uppercase">Selling Price *</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0 bg-light fw-bold">₹</span>
                            <input type="number" step="0.01" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror" value="{{ old('selling_price') }}" required placeholder="0.00">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted uppercase">Purchase Price</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0 bg-light">₹</span>
                            <input type="number" step="0.01" name="purchase_price" class="form-control" value="{{ old('purchase_price') }}" placeholder="0.00">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted uppercase">Tax Rate *</label>
                        <select name="tax_rate" class="form-select" required>
                            <option value="0" {{ old('tax_rate') == 0 ? 'selected' : '' }}>0% (Exempt)</option>
                            <option value="5" {{ old('tax_rate') == 5 ? 'selected' : '' }}>5%</option>
                            <option value="12" {{ old('tax_rate', 12) == 12 ? 'selected' : '' }}>12%</option>
                            <option value="18" {{ old('tax_rate', 18) == 18 ? 'selected' : '' }}>18%</option>
                            <option value="28" {{ old('tax_rate') == 28 ? 'selected' : '' }}>28%</option>
                        </select>
                    </div>

                    <label class="form-label fw-bold small text-muted uppercase mb-2">Tax Type</label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tax_type" id="taxExcl" value="exclusive" checked>
                            <label class="form-check-label small" for="taxExcl">Exclusive</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tax_type" id="taxIncl" value="inclusive">
                            <label class="form-check-label small" for="taxIncl">Inclusive</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock Card -->
            <div class="card border-0 shadow-sm card-dashboard">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4 d-flex align-items-center uppercase extra-small text-muted">
                        <i class="bi bi-stack me-2 text-primary"></i> Inventory Settings
                    </h6>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted uppercase">Unit *</label>
                        <input type="text" name="unit" class="form-control" value="{{ old('unit', 'PCS') }}" required placeholder="e.g. PCS, Kgs">
                    </div>

                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <label class="form-label fw-bold small text-muted uppercase">Opening Stock</label>
                            <input type="number" step="0.001" name="opening_stock" class="form-control" value="{{ old('opening_stock', 0) }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small text-muted uppercase">Min Alert</label>
                            <input type="number" step="0.001" name="min_stock_level" class="form-control" value="{{ old('min_stock_level', 5) }}">
                        </div>
                    </div>

                    <div class="form-check form-switch bg-light p-3 rounded-3 ps-5">
                        <input class="form-check-input ms-n4" type="checkbox" name="is_active" id="isActive" checked>
                        <label class="form-check-label small fw-bold uppercase text-dark ms-2" for="isActive">Active Status</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-2">
            <div class="card border-0 shadow-sm bg-primary text-white card-dashboard p-2">
                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold border-0">
                    <i class="bi bi-save-fill me-2"></i> SAVE PRODUCT & CONTINUE
                </button>
            </div>
        </div>
    </div>
</form>

<style>
    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
    .extra-small { font-size: 11px; }
    .btn-white { background: #fff; color: #1a202c; }
</style>

@endsection
