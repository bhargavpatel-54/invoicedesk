@extends('layouts.app')

@section('title', 'Edit Invoice - ' . $invoice->invoice_number)

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-12">
        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-0">Edit Sale Invoice: {{ $invoice->invoice_number }}</h4>
                <p class="text-muted small mb-0">Update the details of your invoice. Note: Stock will be recalculated automatically.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-white border shadow-sm btn-sm px-3 text-primary fw-semibold">
                    <i class="bi bi-eye me-1"></i> View
                </a>
                <a href="{{ route('invoices.index') }}" class="btn btn-white border shadow-sm btn-sm px-3">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        <form id="invoiceForm" action="{{ route('invoices.update', $invoice) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-4">
                <!-- Header Info -->
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm card-dashboard">
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-muted">Customer *</label>
                                    <select name="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                                        <option value="">Select Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ (old('customer_id', $invoice->customer_id) == $customer->id) ? 'selected' : '' }}>
                                                {{ $customer->business_name }} ({{ $customer->phone }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold small text-muted">Invoice # *</label>
                                    <input type="text" name="invoice_number" class="form-control @error('invoice_number') is-invalid @enderror" value="{{ old('invoice_number', $invoice->invoice_number) }}" required>
                                    @error('invoice_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold small text-muted">Invoice Date *</label>
                                    <input type="date" name="invoice_date" class="form-control" value="{{ old('invoice_date', $invoice->invoice_date->format('Y-m-d')) }}" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold small text-muted">Due Date</label>
                                    <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold small text-muted">Reference #</label>
                                    <input type="text" name="reference_number" class="form-control" value="{{ old('reference_number', $invoice->reference_number) }}" placeholder="e.g. PO-123">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm card-dashboard">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-0" id="itemsTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4 py-3 small text-muted uppercase fw-bold" style="width: 30%;">Product / Service</th>
                                            <th class="py-3 small text-muted uppercase fw-bold" style="width: 10%;">QTY</th>
                                            <th class="py-3 small text-muted uppercase fw-bold" style="width: 15%;">Rate (₹)</th>
                                            <th class="py-3 small text-muted uppercase fw-bold" style="width: 10%;">Disc %</th>
                                            <th class="py-3 small text-muted uppercase fw-bold" style="width: 10%;">GST %</th>
                                            <th class="py-3 small text-muted uppercase fw-bold text-end" style="width: 15%;">Amount (₹)</th>
                                            <th class="pe-4 py-3 text-center" style="width: 5%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="invoiceItems">
                                        @foreach($invoice->items as $index => $item)
                                        <tr class="item-row border-bottom">
                                            <td class="ps-4 py-3">
                                                <select name="items[{{ $index }}][product_id]" class="form-select product-select" required>
                                                    <option value="">Select Product</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}" 
                                                                data-price="{{ $product->selling_price }}" 
                                                                data-tax="{{ $product->tax_rate }}"
                                                                data-unit="{{ $product->unit }}"
                                                                {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                            {{ $product->name }} ({{ $product->current_stock }} {{ $product->unit }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="py-3">
                                                <input type="number" name="items[{{ $index }}][quantity]" class="form-control qty-input" value="{{ $item->quantity + 0 }}" step="0.001" required>
                                            </td>
                                            <td class="py-3">
                                                <input type="number" name="items[{{ $index }}][rate]" class="form-control rate-input" value="{{ $item->rate }}" step="0.01" required>
                                            </td>
                                            <td class="py-3">
                                                <input type="number" name="items[{{ $index }}][discount_percentage]" class="form-control disc-input" value="{{ $item->discount_percentage + 0 }}" step="0.01">
                                            </td>
                                            <td class="py-3">
                                                <input type="number" name="items[{{ $index }}][tax_rate]" class="form-control tax-input" value="{{ $item->tax_rate + 0 }}" step="0.01">
                                            </td>
                                            <td class="py-3 text-end fw-bold">
                                                <span class="row-total">{{ number_format($item->total_amount, 2) }}</span>
                                            </td>
                                            <td class="pe-4 py-3 text-center">
                                                <button type="button" class="btn btn-outline-danger btn-sm border-0 rounded-circle remove-row"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-3 border-top bg-light">
                                <button type="button" class="btn btn-white border shadow-sm btn-sm fw-bold px-3" id="addRow">
                                    <i class="bi bi-plus-lg me-1 text-primary"></i> Add Line Item
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer: Summary & Totals -->
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm card-dashboard h-100">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <label class="form-label fw-semibold small text-muted">Notes / Special Instructions</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Will be visible on the invoice...">{{ old('notes', $invoice->notes) }}</textarea>
                            </div>
                            <div>
                                <label class="form-label fw-semibold small text-muted">Terms & Conditions</label>
                                <textarea name="terms_conditions" class="form-control" rows="3" placeholder="Payment terms, return policy, etc...">{{ old('terms_conditions', $invoice->terms_conditions) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm card-dashboard">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Sub Total</span>
                                <span class="fw-bold" id="totalSubtotal">₹ {{ number_format($invoice->subtotal, 2) }}</span>
                            </div>
                            
                            <div class="row g-2 align-items-center mb-2">
                                <div class="col-7">
                                    <span class="text-muted">Overall Discount</span>
                                    <div class="d-flex gap-2 mt-1">
                                        <select name="discount_type" class="form-select form-select-sm w-auto" id="discountType">
                                            <option value="fixed" {{ $invoice->discount_type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                            <option value="percentage" {{ $invoice->discount_type == 'percentage' ? 'selected' : '' }}>%</option>
                                        </select>
                                        <input type="number" name="discount_value" id="discountValue" class="form-control form-select-sm" value="{{ $invoice->discount_value + 0 }}" step="0.01">
                                    </div>
                                </div>
                                <div class="col-5 text-end">
                                    <span class="fw-bold text-danger" id="totalDiscount">(-) ₹ {{ number_format($invoice->discount_amount, 2) }}</span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-2 text-muted small">
                                <span>Taxable Amount</span>
                                <span id="taxableAmount">₹ {{ number_format($invoice->subtotal - $invoice->tax_amount - $invoice->discount_amount, 2) }}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total Tax (GST)</span>
                                <span class="fw-bold text-dark" id="totalTax">₹ {{ number_format($invoice->tax_amount, 2) }}</span>
                            </div>

                            <div class="row g-2 align-items-center mb-3">
                                <div class="col-7">
                                    <label class="text-muted small">Shipping Charges</label>
                                    <input type="number" name="shipping_charges" id="shippingCharges" class="form-control form-control-sm" value="{{ $invoice->shipping_charges + 0 }}" step="0.01">
                                </div>
                                <div class="col-5 text-end">
                                    <span class="fw-bold text-dark" id="displayShipping">₹ {{ number_format($invoice->shipping_charges, 2) }}</span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between pt-3 border-top">
                                <h5 class="fw-bold mb-0">Grand Total</h5>
                                <h5 class="fw-bold mb-0 text-primary" id="grandTotal">₹ {{ number_format($invoice->total_amount, 2) }}</h5>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow">
                                    <i class="bi bi-check-lg me-2"></i> UPDATE INVOICE
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
    .card-dashboard { border-radius: 12px; }
    .btn-white { background: #fff; color: #1a202c; }
    .row-total { font-variant-numeric: tabular-nums; }
</style>

@endsection

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowCount = {{ count($invoice->items) }};

    // Add Row function
    document.getElementById('addRow').addEventListener('click', function() {
        const tbody = document.getElementById('invoiceItems');
        const firstRow = tbody.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);
        
        // Update input names
        newRow.querySelectorAll('input, select').forEach(input => {
            input.name = input.name.replace(/\[\d+\]/, `[${rowCount}]`);
            if (input.tagName === 'INPUT') input.value = input.defaultValue;
            if (input.tagName === 'SELECT') input.selectedIndex = 0;
            if (input.classList.contains('disc-input')) input.value = 0;
            if (input.classList.contains('tax-input')) input.value = 18;
            if (input.classList.contains('qty-input')) input.value = 1;
        });

        newRow.querySelector('.row-total').textContent = '0.00';
        tbody.appendChild(newRow);
        rowCount++;
    });

    // Remove Row event delegation
    document.getElementById('itemsTable').addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            const row = e.target.closest('.item-row');
            if (document.querySelectorAll('.item-row').length > 1) {
                row.remove();
                calculateTotals();
            } else {
                alert('At least one item is required.');
            }
        }
    });

    // Auto-fill price and tax on product selection
    document.getElementById('itemsTable').addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select')) {
            const select = e.target;
            const option = select.options[select.selectedIndex];
            const row = select.closest('.item-row');
            
            if (option.value) {
                row.querySelector('.rate-input').value = option.dataset.price;
                row.querySelector('.tax-input').value = option.dataset.tax;
            }
            calculateTotals();
        }
    });

    // Recalculate on input
    document.getElementById('invoiceForm').addEventListener('input', function(e) {
        if (e.target.matches('.qty-input, .rate-input, .disc-input, .tax-input, #discountType, #discountValue, #shippingCharges')) {
            calculateTotals();
        }
    });

    function calculateTotals() {
        let subtotal = 0;
        let totalTax = 0;

        document.querySelectorAll('.item-row').forEach(row => {
            let qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            let rate = parseFloat(row.querySelector('.rate-input').value) || 0;
            let discPerc = parseFloat(row.querySelector('.disc-input').value) || 0;
            let taxPerc = parseFloat(row.querySelector('.tax-input').value) || 0;

            let baseAmount = qty * rate;
            let discountAmount = (baseAmount * discPerc) / 100;
            let taxableAmount = baseAmount - discountAmount;
            let taxAmount = (taxableAmount * taxPerc) / 100;
            let rowTotal = taxableAmount + taxAmount;

            row.querySelector('.row-total').textContent = rowTotal.toLocaleString('en-IN', { minimumFractionDigits: 2 });
            
            subtotal += rowTotal;
            totalTax += taxAmount;
        });

        // Overall summary
        const discType = document.getElementById('discountType').value;
        const discVal = parseFloat(document.getElementById('discountValue').value) || 0;
        const shipping = parseFloat(document.getElementById('shippingCharges').value) || 0;

        let overallDiscount = (discType === 'percentage') ? (subtotal * discVal / 100) : discVal;
        let grandTotal = (subtotal - overallDiscount) + shipping;

        // Update displays
        document.getElementById('totalSubtotal').textContent = '₹ ' + subtotal.toLocaleString('en-IN', { minimumFractionDigits: 2 });
        document.getElementById('totalDiscount').textContent = '(-) ₹ ' + overallDiscount.toLocaleString('en-IN', { minimumFractionDigits: 2 });
        document.getElementById('taxableAmount').textContent = '₹ ' + (subtotal - totalTax - overallDiscount).toLocaleString('en-IN', { minimumFractionDigits: 2 });
        document.getElementById('totalTax').textContent = '₹ ' + totalTax.toLocaleString('en-IN', { minimumFractionDigits: 2 });
        document.getElementById('displayShipping').textContent = '₹ ' + shipping.toLocaleString('en-IN', { minimumFractionDigits: 2 });
        document.getElementById('grandTotal').textContent = '₹ ' + grandTotal.toLocaleString('en-IN', { minimumFractionDigits: 2 });
    }

    // Initial calculation
    calculateTotals();
});
</script>
@endsection
