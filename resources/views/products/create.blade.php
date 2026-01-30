@extends('layouts.app')

@section('title', 'Add New Product')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-0">Add New Product / Service</h4>
                <p class="text-muted small mb-0">Fill in the details below to create a new item in your inventory.</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-white border shadow-sm btn-sm px-3">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
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
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Enter product name">
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-muted">Category</label>
                                    <input type="text" name="category" class="form-control" value="{{ old('category') }}" placeholder="e.g. Electronics, Service">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-muted">Brand</label>
                                    <input type="text" name="brand" class="form-control" value="{{ old('brand') }}" placeholder="e.g. Samsung, Apple">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-muted">Product Code</label>
                                    <input type="text" name="product_code" class="form-control @error('product_code') is-invalid @enderror" value="{{ old('product_code') }}" placeholder="Unique ID">
                                    @error('product_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-muted">SKU</label>
                                    <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku') }}" placeholder="Stock Keeping Unit">
                                    @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-muted">HSN/SAC Code</label>
                                    <input type="text" name="hsn_code" class="form-control" value="{{ old('hsn_code') }}" placeholder="GST Code">
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-muted">Description</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Detailed product description...">{{ old('description') }}</textarea>
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
                                    <input type="number" step="0.01" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror" value="{{ old('selling_price') }}" required placeholder="0.00">
                                </div>
                                @error('selling_price') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-muted">Purchase Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" step="0.01" name="purchase_price" class="form-control" value="{{ old('purchase_price') }}" placeholder="0.00">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-muted">Tax Rate (%) *</label>
                                <select name="tax_rate" class="form-select" required>
                                    <option value="0" {{ old('tax_rate') == 0 ? 'selected' : '' }}>0% (Exempted)</option>
                                    <option value="5" {{ old('tax_rate') == 5 ? 'selected' : '' }}>5%</option>
                                    <option value="12" {{ old('tax_rate') == 12 ? 'selected' : '' }}>12%</option>
                                    <option value="18" {{ old('tax_rate', 18) == 18 ? 'selected' : '' }}>18%</option>
                                    <option value="28" {{ old('tax_rate') == 28 ? 'selected' : '' }}>28%</option>
                                </select>
                            </div>

                            <div class="mb-0">
                                <label class="form-label fw-semibold small text-muted">Tax Type</label>
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
                    </div>

                    <!-- Stock Setting -->
                    <div class="card border-0 shadow-sm card-dashboard">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="bi bi-inventory me-2 text-primary"></i> Stock Settings
                            </h6>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-muted">Primary Unit *</label>
                                <input type="text" name="unit" class="form-control" value="{{ old('unit', 'PCS') }}" required placeholder="e.g. PCS, Kgs, Box">
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label fw-semibold small text-muted">Opening Stock</label>
                                    <input type="number" step="0.001" name="opening_stock" class="form-control" value="{{ old('opening_stock', 0) }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-semibold small text-muted">Low Stock Alert</label>
                                    <input type="number" step="0.001" name="min_stock_level" class="form-control" value="{{ old('min_stock_level', 5) }}">
                                </div>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked>
                                <label class="form-check-label small fw-semibold" for="isActive">Product is Active</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-4 text-end">
                    <hr class="mb-4 opacity-25">
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow">
                        <i class="bi bi-save me-1"></i> Create Product
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
