@extends('layouts.app')

@section('title', 'Inventory / Products')

@section('content')

<!-- Page Header -->
<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <!-- Desktop Header (Big Screen Only) -->
        <div class="d-none d-md-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="mb-2 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-box-seam-fill me-2"></i>Inventory Management
                </h5>
                <div class="d-flex gap-4 mt-2 small text-muted">
                    <span><i class="bi bi-circle-fill text-primary me-1" style="font-size: 8px;"></i>Total: <b class="text-dark">{{ $totalCount }}</b></span>
                    <span><i class="bi bi-circle-fill text-success me-1" style="font-size: 8px;"></i>In Stock: <b class="text-dark">{{ $inStockCount }}</b></span>
                    <span><i class="bi bi-circle-fill text-warning me-1" style="font-size: 8px;"></i>Low Stock: <b class="text-dark">{{ $lowStockCount }}</b></span>
                </div>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <form action="{{ route('products.index') }}" method="GET" class="d-flex gap-1 mb-0">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search..." style="width: 150px;">
                    <select name="stock_status" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 120px;">
                        <option value="">All Stock</option>
                        <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                        <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                    <button type="submit" class="btn btn-white border shadow-sm btn-sm">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                <a href="{{ route('products.create') }}" class="btn btn-primary text-white btn-sm px-3 fw-semibold shadow">
                    <i class="bi bi-plus-lg me-1"></i> Add New
                </a>
            </div>
        </div>

        <!-- Mobile Header (Small Screen Only) -->
        <div class="d-md-none">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-box-seam-fill me-2"></i>Inventory
                </h5>
                <a href="{{ route('products.create') }}" class="btn btn-primary text-white btn-sm px-3 fw-semibold shadow">
                    <i class="bi bi-plus-lg me-1"></i> New
                </a>
            </div>
            <div class="d-flex gap-2 mb-3">
                <form action="{{ route('products.index') }}" method="GET" class="d-flex gap-1 mb-0 flex-grow-1">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search...">
                    <button type="submit" class="btn btn-white border shadow-sm btn-sm">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                <select name="stock_status" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 110px;">
                    <option value="">Stock</option>
                    <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                    <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                    <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>
            <div class="d-flex justify-content-around small text-muted bg-light p-2 rounded-3">
                <span>Total: <b class="text-dark">{{ $totalCount }}</b></span>
                <span>In: <b class="text-dark">{{ $inStockCount }}</b></span>
                <span>Low: <b class="text-dark">{{ $lowStockCount }}</b></span>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Products Grid -->
<div class="row g-4">
    @forelse($products as $product)
    <div class="col-md-4 col-xl-3">
        <div class="card border-0 shadow-sm card-dashboard h-100 product-card" onclick="window.location='{{ route('products.show', $product) }}'" style="cursor: pointer;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    @php
                        $grad = 'linear-gradient(135deg, rgba(33, 150, 243, 0.1), rgba(3, 169, 244, 0.15))';
                        $iconColor = '#2196f3';
                        if($product->current_stock <= 0) {
                            $grad = 'linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(220, 53, 69, 0.15))';
                            $iconColor = '#dc3545';
                        } elseif($product->current_stock <= $product->min_stock_level) {
                            $grad = 'linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 179, 0, 0.15))';
                            $iconColor = '#ffc107';
                        }
                    @endphp
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 56px; height: 56px; background: {{ $grad }}; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                        <i class="bi bi-box-seam fs-4" style="color: {{ $iconColor }};"></i>
                    </div>
                    <div class="dropdown" onclick="event.stopPropagation()">
                        <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li><a class="dropdown-item" href="{{ route('products.show', $product) }}"><i class="bi bi-eye me-2"></i> View Details</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.edit', $product) }}"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="if(confirm('Are you sure you want to delete this product?')) document.getElementById('delete-product-{{ $product->id }}').submit()"><i class="bi bi-trash me-2"></i> Delete</a></li>
                            <form id="delete-product-{{ $product->id }}" action="{{ route('products.destroy', $product) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </ul>
                    </div>
                </div>
                <h6 class="fw-bold mb-1 text-truncate" title="{{ $product->name }}">{{ $product->name }}</h6>
                <p class="text-muted extra-small mb-3">SKU: {{ $product->sku ?? 'N/A' }} | Code: {{ $product->product_code ?? 'N/A' }}</p>
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <small class="text-muted d-block small uppercase fw-bold" style="font-size: 9px;">Selling Price</small>
                        <span class="fw-bold text-dark">₹ {{ number_format($product->selling_price, 2) }}</span>
                    </div>
                    <div class="text-end">
                        <small class="text-muted d-block small uppercase fw-bold" style="font-size: 9px;">Stock</small>
                        <span class="fw-bold {{ $product->current_stock <= $product->min_stock_level ? 'text-danger' : 'text-success' }}">
                            {{ number_format($product->current_stock, 0) }} {{ $product->unit }}
                        </span>
                    </div>
                </div>

                <div class="mt-auto pt-3 border-top" onclick="event.stopPropagation()">
                    <div class="d-flex gap-2">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-white border shadow-sm flex-fill fw-semibold">
                            <i class="bi bi-pencil me-1 text-primary"></i> Edit
                        </a>
                        <button class="btn btn-sm btn-white border shadow-sm flex-fill fw-semibold" data-bs-toggle="modal" data-bs-target="#stockModal{{ $product->id }}">
                            <i class="bi bi-plus-minus me-1 text-success"></i> Adjust Stock
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Modal -->
    <div class="modal fade" id="stockModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Adjust Stock: {{ $product->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('products.add-stock', $product) }}" method="POST">
                    @csrf
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted">Movement Type</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="typeIn{{ $product->id }}" value="in" checked>
                                    <label class="form-check-label" for="typeIn{{ $product->id }}">Stock In (Add)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="typeOut{{ $product->id }}" value="out">
                                    <label class="form-check-label" for="typeOut{{ $product->id }}">Stock Out (Remove)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-muted">Quantity</label>
                                <div class="input-group">
                                    <input type="number" step="0.001" name="quantity" class="form-control" required placeholder="0.00">
                                    <span class="input-group-text">{{ $product->unit }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-muted">Current Stock</label>
                                <input type="text" class="form-control bg-light" value="{{ $product->current_stock + 0 }} {{ $product->unit }}" readonly>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label fw-semibold small text-muted">Notes (Optional)</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Reason for adjustment..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-white border btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm px-4 shadow">Update Stock</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="text-muted">
            <i class="bi bi-box fs-1 d-block mb-3 opacity-25"></i>
            No products found matching your search.
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>

<style>
    .product-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border-radius: 12px;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    .extra-small {
        font-size: 11px;
    }
    .uppercase {
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
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
