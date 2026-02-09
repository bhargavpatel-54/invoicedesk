@extends('layouts.app')

@section('title', 'Edit Product - ' . $product->name)

@section('content')

<!-- Page Header -->
<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <!-- Desktop Header -->
        <div class="d-none d-md-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="mb-1 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #3b82f6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-pencil-square me-2"></i>Edit Product
                </h5>
                <p class="text-muted small mb-0">Updating details for <b>{{ $product->name }}</b></p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('products.show', $product) }}" class="btn btn-white border shadow-sm btn-sm px-3 text-primary">
                    <i class="bi bi-eye me-1"></i> View Details
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-white border shadow-sm btn-sm px-3">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        <!-- Mobile Header -->
        <div class="d-md-none text-center">
            <h5 class="mb-2 fw-bold">Edit Product</h5>
            <p class="text-muted extra-small mb-3">{{ $product->name }}</p>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('products.index') }}" class="btn btn-white border shadow-sm btn-sm w-100">
                    <i class="bi bi-arrow-left me-1"></i> Cancel
                </a>
                <a href="{{ route('products.show', $product) }}" class="btn btn-white border shadow-sm btn-sm">
                    <i class="bi bi-eye text-primary"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('products.update', $product) }}" method="POST">
    @csrf
    @method('PUT')
    
    <!-- Top Errors removed for inline display -->

    
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
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted uppercase">Category</label>
                            <input type="text" name="category" class="form-control" value="{{ old('category', $product->category) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted uppercase">Brand</label>
                            <input type="text" name="brand" class="form-control" value="{{ old('brand', $product->brand) }}">
                        </div>

                        <div class="col-6 col-md-4">
                            <label class="form-label fw-bold small text-muted uppercase">Code</label>
                            <input type="text" name="product_code" class="form-control @error('product_code') is-invalid @enderror" value="{{ old('product_code', $product->product_code) }}">
                            @error('product_code')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-6 col-md-4">
                            <label class="form-label fw-bold small text-muted uppercase">SKU</label>
                            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $product->sku) }}">
                            @error('sku')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label fw-bold small text-muted uppercase">HSN/SAC Code</label>
                            <input type="text" name="hsn_code" class="form-control" value="{{ old('hsn_code', $product->hsn_code) }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted uppercase">Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
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
                            <input type="number" step="0.01" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror" value="{{ old('selling_price', $product->selling_price) }}" required>
                        </div>
                        @error('selling_price')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted uppercase">Purchase Price</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0 bg-light">₹</span>
                            <input type="number" step="0.01" name="purchase_price" class="form-control" value="{{ old('purchase_price', $product->purchase_price) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted uppercase">Tax Rate *</label>
                        <select name="tax_rate" class="form-select @error('tax_rate') is-invalid @enderror" required>
                            <option value="0" {{ old('tax_rate', $product->tax_rate) == 0 ? 'selected' : '' }}>0% (Exempt)</option>
                            <option value="5" {{ old('tax_rate', $product->tax_rate) == 5 ? 'selected' : '' }}>5%</option>
                            <option value="12" {{ old('tax_rate', $product->tax_rate) == 12 ? 'selected' : '' }}>12%</option>
                            <option value="18" {{ old('tax_rate', $product->tax_rate) == 18 ? 'selected' : '' }}>18%</option>
                            <option value="28" {{ old('tax_rate', $product->tax_rate) == 28 ? 'selected' : '' }}>28%</option>
                        </select>
                        @error('tax_rate')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <label class="form-label fw-bold small text-muted uppercase mb-2">Tax Type</label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tax_type" id="taxExcl" value="exclusive" {{ old('tax_type', $product->tax_type) == 'exclusive' ? 'checked' : '' }}>
                            <label class="form-check-label small" for="taxExcl">Exclusive</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tax_type" id="taxIncl" value="inclusive" {{ old('tax_type', $product->tax_type) == 'inclusive' ? 'checked' : '' }}>
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
                        <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror" value="{{ old('unit', $product->unit) }}" required>
                        @error('unit')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted uppercase">Min Low Alert</label>
                        <input type="number" step="0.001" name="min_stock_level" class="form-control" value="{{ old('min_stock_level', $product->min_stock_level) }}">
                    </div>

                    <div class="form-check form-switch bg-light p-3 rounded-3 ps-5 mb-3">
                        <input class="form-check-input ms-n4" type="checkbox" name="is_active" id="isActive" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label small fw-bold uppercase text-dark ms-2" for="isActive">Active Status</label>
                    </div>
                    
                    <div class="bg-gray-50 p-2 rounded border border-dashed text-center">
                        <span class="small text-muted d-block uppercase extra-small fw-bold">Current Physical Stock</span>
                        <span class="fw-bold fs-5 text-primary">{{ $product->current_stock + 0 }} {{ $product->unit }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-2">
            <div class="card border-0 shadow-sm bg-primary text-white card-dashboard p-2">
                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold border-0">
                    <i class="bi bi-check-circle-fill me-2"></i> UPDATE PRODUCT DETAILS
                </button>
            </div>
        </div>
    </div>
</form>

<style>
    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
    .extra-small { font-size: 11px; }
    .btn-white { background: #fff; color: #1a202c; }
    .border-dashed { border-style: dashed !important; }
</style>

@endsection
