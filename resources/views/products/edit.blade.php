@extends('layouts.app')

@section('title', 'Edit Product - ' . $product->name)

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-0">Edit Product / Service</h4>
                <p class="text-muted small mb-0">Update the details for <b>{{ $product->name }}</b>.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('products.show', $product) }}" class="btn btn-white border shadow-sm btn-sm px-3 text-primary fw-semibold">
                    <i class="bi bi-eye me-1"></i> View
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-white border shadow-sm btn-sm px-3">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-4">
                <!-- Basic Info -->
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm card-dashboard h-100">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="bi bi-info-circle-fill me-2 text-primary"></i> Basic Information
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold small text-muted">Product / Service Name *</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-muted">Category</label>
                                    <input type="text" name="category" class="form-control" value="{{ old('category', $product->category) }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-muted">Brand</label>
                                    <input type="text" name="brand" class="form-control" value="{{ old('brand', $product->brand) }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-muted">Product Code</label>
                                    <input type="text" name="product_code" class="form-control @error('product_code') is-invalid @enderror" value="{{ old('product_code', $product->product_code) }}">
                                    @error('product_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-muted">SKU</label>
                                    <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $product->sku) }}">
                                    @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-muted">HSN/SAC Code</label>
                                    <input type="text" name="hsn_code" class="form-control" value="{{ old('hsn_code', $product->hsn_code) }}">
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-muted">Description</label>
                                    <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing & Tax -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm card-dashboard mb-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="bi bi-currency-rupee me-2 text-primary"></i> Pricing & Tax
                            </h6>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-muted">Selling Price *</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" step="0.01" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror" value="{{ old('selling_price', $product->selling_price) }}" required>
                                </div>
                                @error('selling_price') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-muted">Purchase Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" step="0.01" name="purchase_price" class="form-control" value="{{ old('purchase_price', $product->purchase_price) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-muted">Tax Rate (%) *</label>
                                <select name="tax_rate" class="form-select" required>
                                    <option value="0" {{ old('tax_rate', $product->tax_rate) == 0 ? 'selected' : '' }}>0% (Exempted)</option>
                                    <option value="5" {{ old('tax_rate', $product->tax_rate) == 5 ? 'selected' : '' }}>5%</option>
                                    <option value="12" {{ old('tax_rate', $product->tax_rate) == 12 ? 'selected' : '' }}>12%</option>
                                    <option value="18" {{ old('tax_rate', $product->tax_rate) == 18 ? 'selected' : '' }}>18%</option>
                                    <option value="28" {{ old('tax_rate', $product->tax_rate) == 28 ? 'selected' : '' }}>28%</option>
                                </select>
                            </div>

                            <div class="mb-0">
                                <label class="form-label fw-semibold small text-muted">Tax Type</label>
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
                    </div>

                    <!-- Stock Setting -->
                    <div class="card border-0 shadow-sm card-dashboard">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="bi bi-inventory me-2 text-primary"></i> Stock Settings
                            </h6>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-muted">Primary Unit *</label>
                                <input type="text" name="unit" class="form-control" value="{{ old('unit', $product->unit) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-muted">Low Stock Alert</label>
                                <input type="number" step="0.001" name="min_stock_level" class="form-control" value="{{ old('min_stock_level', $product->min_stock_level) }}">
                            </div>

                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label small fw-semibold" for="isActive">Product is Active</label>
                            </div>
                            
                            <div class="bg-light p-3 rounded-2 border">
                                <span class="small text-muted d-block">Current Stock Level:</span>
                                <span class="fw-bold fs-5">{{ $product->current_stock + 0 }} {{ $product->unit }}</span>
                                <div class="mt-1">
                                    <small class="text-muted" style="font-size: 10px;">Stock can be adjusted via the "Adjust Stock" button on the details page.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-4 text-end">
                    <hr class="mb-4 opacity-25">
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow">
                        <i class="bi bi-check-lg me-1"></i> Update Product
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .card-dashboard {
        border-radius: 12px;
    }
    .btn-white {
        background: #fff;
        color: #1a202c;
    }
    .btn-white:hover {
        background: #f8f9fa;
        color: #1a202c;
    }
</style>

@endsection
