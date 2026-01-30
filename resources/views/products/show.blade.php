@extends('layouts.app')

@section('title', $product->name . ' - Product Details')

@section('content')

<div class="row g-4">
    <!-- Main Info -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm card-dashboard mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10" style="width: 64px; height: 64px;">
                            <i class="bi bi-box-seam fs-3 text-primary"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold text-dark">{{ $product->name }}</h4>
                            <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }} px-3 rounded-pill">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('products.index') }}" class="btn btn-white border shadow-sm btn-sm px-3 fw-semibold">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-white border shadow-sm btn-sm px-3 fw-semibold">
                            <i class="bi bi-pencil me-1 text-primary"></i> Edit
                        </a>
                        <button class="btn btn-white border shadow-sm btn-sm px-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#stockModal">
                            <i class="bi bi-plus-minus me-1 text-success"></i> manage</button>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="d-block text-muted extra-small uppercase fw-bold mb-1">Selling Price</label>
                        <p class="h5 fw-bold text-dark">₹ {{ number_format($product->selling_price, 2) }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="d-block text-muted extra-small uppercase fw-bold mb-1">Purchase Price</label>
                        <p class="h5 fw-bold text-muted">₹ {{ number_format($product->purchase_price, 2) }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="d-block text-muted extra-small uppercase fw-bold mb-1">Current Stock</label>
                        <p class="h5 fw-bold {{ $product->current_stock <= $product->min_stock_level ? 'text-danger' : 'text-success' }}">
                            {{ number_format($product->current_stock, 0) }} {{ $product->unit }}
                        </p>
                    </div>
                    
                    <div class="col-12"><hr class="my-2 opacity-25"></div>

                    <div class="col-md-3">
                        <label class="d-block text-muted extra-small uppercase fw-bold mb-1">Product Code</label>
                        <p class="fw-semibold">{{ $product->product_code ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="d-block text-muted extra-small uppercase fw-bold mb-1">SKU</label>
                        <p class="fw-semibold">{{ $product->sku ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="d-block text-muted extra-small uppercase fw-bold mb-1">HSN/SAC Code</label>
                        <p class="fw-semibold">{{ $product->hsn_code ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="d-block text-muted extra-small uppercase fw-bold mb-1">Tax Rate</label>
                        <p class="fw-semibold">{{ $product->tax_rate + 0 }}% ({{ ucfirst($product->tax_type) }})</p>
                    </div>

                    @if($product->description)
                    <div class="col-12">
                        <label class="d-block text-muted extra-small uppercase fw-bold mb-1">Description</label>
                        <div class="bg-light p-3 rounded-3 mt-1">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stock Movement History -->
        <div class="card border-0 shadow-sm card-dashboard">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4 d-flex align-items-center">
                    <i class="bi bi-clock-history me-2 text-primary"></i> Recent Stock Movements
                </h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-3 small text-muted">Date</th>
                                <th class="border-0 px-3 small text-muted">Type</th>
                                <th class="border-0 px-3 small text-muted">Details</th>
                                <th class="border-0 px-3 small text-muted text-end">Quantity</th>
                                <th class="border-0 px-3 small text-muted text-end">Stock After</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($movements as $move)
                            <tr>
                                <td class="px-3">
                                    <span class="text-dark fw-medium small">{{ $move->movement_date->format('d M Y') }}</span>
                                    <small class="d-block text-muted" style="font-size: 10px;">{{ $move->created_at->format('H:i') }}</small>
                                </td>
                                <td class="px-3">
                                    <span class="badge {{ $move->movement_type == 'in' ? 'bg-success' : 'bg-danger' }} bg-opacity-10 {{ $move->movement_type == 'in' ? 'text-success' : 'text-danger' }} rounded-pill px-3">
                                        Stock {{ ucfirst($move->movement_type) }}
                                    </span>
                                </td>
                                <td class="px-3">
                                    <span class="small text-dark fw-medium">{{ ucwords(str_replace('_', ' ', $move->transaction_type)) }}</span>
                                    @if($move->notes)
                                        <small class="d-block text-muted">{{ $move->notes }}</small>
                                    @endif
                                </td>
                                <td class="px-3 text-end fw-bold {{ $move->movement_type == 'in' ? 'text-success' : 'text-danger' }}">
                                    {{ $move->movement_type == 'in' ? '+' : '-' }} {{ number_format($move->quantity, 0) }}
                                </td>
                                <td class="px-3 text-end fw-bold text-dark">
                                    {{ number_format($move->stock_after, 0) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-muted">No movements recorded yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Sidebar -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm card-dashboard mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="p-4 bg-primary text-white">
                    <h6 class="uppercase extra-small opacity-75 fw-bold mb-1">Stock Value (at Purchase)</h6>
                    <h3 class="fw-bold mb-0">₹ {{ number_format($product->current_stock * $product->purchase_price, 2) }}</h3>
                </div>
                <div class="p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted small">Opening Stock</span>
                        <span class="fw-bold text-dark small">{{ $product->opening_stock + 0 }} {{ $product->unit }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted small">Min Stock Level</span>
                        <span class="fw-bold text-warning small">{{ $product->min_stock_level + 0 }} {{ $product->unit }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-0">
                        <span class="text-muted small">Category</span>
                        <span class="fw-bold text-dark small">{{ $product->category ?? 'General' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm card-dashboard bg-light">
            <div class="card-body p-4 text-center">
                <div class="mb-3">
                    <i class="bi bi-info-circle text-primary fs-4"></i>
                </div>
                <h6 class="fw-bold">Stock Alerts</h6>
                <p class="text-muted small">Low stock alerts will appear on your dashboard when current stock falls below <b>{{ $product->min_stock_level + 0 }}</b> units.</p>
            </div>
        </div>
    </div>
</div>

<!-- Stock Modal -->
<div class="modal fade" id="stockModal" tabindex="-1" aria-hidden="true">
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
                                <input class="form-check-input" type="radio" name="type" id="typeIn" value="in" checked>
                                <label class="form-check-label" for="typeIn">Stock In (Add)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="typeOut" value="out">
                                <label class="form-check-label" for="typeOut">Stock Out (Remove)</label>
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

<style>
    .card-dashboard {
        border-radius: 12px;
    }
    .extra-small {
        font-size: 11px;
    }
    .uppercase {
        text-transform: uppercase;
        letter-spacing: 0.5px;
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
