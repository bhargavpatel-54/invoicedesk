@extends('layouts.app')

@section('title', 'Create New Invoice')

@section('content')

<!-- Page Header -->
<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <!-- Desktop Header -->
        <div class="d-none d-md-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="mb-1 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #3b82f6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-file-earmark-plus-fill me-2"></i>Create Sale Invoice
                </h5>
                <p class="text-muted small mb-0">Generate a professional GST invoice for your customer.</p>
            </div>
            <a href="{{ route('invoices.index') }}" class="btn btn-white border shadow-sm btn-sm px-3">
                <i class="bi bi-arrow-left me-1"></i> Back to Invoices
            </a>
        </div>

        <!-- Mobile Header -->
        <div class="d-md-none text-center">
            <h5 class="mb-3 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #3b82f6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <i class="bi bi-file-earmark-plus-fill me-2"></i>New Invoice
            </h5>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('invoices.index') }}" class="btn btn-white border shadow-sm btn-sm w-100">
                    <i class="bi bi-arrow-left me-1"></i> Cancel
                </a>
            </div>
        </div>
    </div>
</div>

<form id="invoiceForm" action="{{ route('invoices.store') }}" method="POST">
    @csrf
    
    <div class="row g-4">
        <!-- Header Info -->
        <div class="col-md-12">
            <div class="card border-0 shadow-sm card-dashboard">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted uppercase">Customer *</label>
                            <select name="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->business_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-6 col-md-2">
                            <label class="form-label fw-bold small text-muted uppercase">Invoice # *</label>
                            <input type="text" name="invoice_number" class="form-control @error('invoice_number') is-invalid @enderror" value="{{ old('invoice_number', $nextInvoiceNumber) }}" required>
                        </div>
                        <div class="col-6 col-md-2">
                            <label class="form-label fw-bold small text-muted uppercase">Date *</label>
                            <input type="date" name="invoice_date" class="form-control" value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                        </div>
                        <div class="col-6 col-md-2">
                            <label class="form-label fw-bold small text-muted uppercase">Due Date</label>
                            <input type="date" name="due_date" class="form-control" value="{{ old('due_date', date('Y-m-d')) }}">
                        </div>
                        <div class="col-6 col-md-2">
                            <label class="form-label fw-bold small text-muted uppercase">Ref #</label>
                            <input type="text" name="reference_number" class="form-control" value="{{ old('reference_number') }}" placeholder="e.g. PO-123">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="col-md-12">
            <div class="card border-0 shadow-sm card-dashboard">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold small uppercase">Line Items</h6>
                    <button type="button" class="btn btn-primary btn-sm px-3 shadow-sm d-md-none" id="addRowMobile">
                        <i class="bi bi-plus-lg"></i> Add Item
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0" id="itemsTable">
                            <!-- Headers removed in favor of in-field labels -->
                            <tbody id="invoiceItems">
                                <!-- Item Row Template -->
                                <tr class="item-row border-bottom">
                                    <td class="ps-md-4 py-4">
                                        <label class="extra-small fw-bold text-muted mb-1 uppercase d-block">Product / Service</label>
                                        <select name="items[0][product_id]" class="form-select product-select" required>
                                            <option value="">Select Product</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" 
                                                        data-price="{{ $product->selling_price }}" 
                                                        data-tax="{{ $product->tax_rate }}"
                                                        data-unit="{{ $product->unit }}">
                                                    {{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="py-4">
                                        <label class="extra-small fw-bold text-muted mb-1 uppercase d-block">Quantity</label>
                                        <input type="number" name="items[0][quantity]" class="form-control qty-input text-md-center" value="1" step="0.001" required>
                                    </td>
                                    <td class="py-4">
                                        <label class="extra-small fw-bold text-muted mb-1 uppercase d-block">Rate (₹)</label>
                                        <input type="number" name="items[0][rate]" class="form-control rate-input" step="0.01" required>
                                    </td>
                                    <td class="py-4">
                                        <label class="extra-small fw-bold text-muted mb-1 uppercase d-block">Disc %</label>
                                        <input type="number" name="items[0][discount_percentage]" class="form-control disc-input" value="0" step="0.01">
                                    </td>
                                    <td class="py-4">
                                        <label class="extra-small fw-bold text-muted mb-1 uppercase d-block">GST %</label>
                                        <input type="number" name="items[0][tax_rate]" class="form-control tax-input" value="18" step="0.01">
                                    </td>
                                    <td class="py-4 text-end fw-bold">
                                        <label class="extra-small fw-bold text-muted mb-1 uppercase d-block text-end">Amount</label>
                                        <span class="row-total d-block mt-2">0.00</span>
                                    </td>
                                    <td class="pe-md-4 py-4 text-end text-md-center">
                                        <label class="extra-small fw-bold text-transparent mb-1 uppercase d-none d-md-block">Action</label>
                                        <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-row mt-md-2">
                                            <i class="bi bi-trash"></i> <span class="d-md-none">Remove</span>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3 border-top bg-light d-none d-md-block">
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
                        <label class="form-label fw-bold small text-muted uppercase">Notes / Instructions</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Will be visible on invoice..."></textarea>
                    </div>
                    <div>
                        <label class="form-label fw-bold small text-muted uppercase">Terms & Conditions</label>
                        <textarea name="terms_conditions" class="form-control" rows="3">1. Goods once sold will not be taken back.
2. Interest @ 18% p.a. will be charged if payment is not made within due date.</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card border-0 shadow-sm card-dashboard border-primary border-top border-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2 border-dashed">
                        <span class="text-muted">Sub Total</span>
                        <span class="fw-bold text-dark" id="totalSubtotal">₹ 0.00</span>
                    </div>
                    
                    <div class="row g-2 align-items-center mb-3">
                        <div class="col-7">
                            <div class="d-flex gap-2">
                                <select name="discount_type" class="form-select form-select-sm w-auto" id="discountType">
                                    <option value="fixed">Disc ₹</option>
                                    <option value="percentage">Disc %</option>
                                </select>
                                <input type="number" name="discount_value" id="discountValue" class="form-control form-control-sm" value="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-5 text-end">
                            <span class="fw-bold text-danger" id="totalDiscount">(-) ₹ 0.00</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2 border-dashed text-muted small">
                        <span>Taxable Amount</span>
                        <span id="taxableAmount" class="fw-bold text-dark">₹ 0.00</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2 border-dashed">
                        <span class="text-muted">GST Total</span>
                        <span class="fw-bold text-dark" id="totalTax">₹ 0.00</span>
                    </div>

                    <div class="row g-2 align-items-center mb-4">
                        <div class="col-7">
                            <label class="text-muted small fw-bold uppercase px-1">Shipping</label>
                            <input type="number" name="shipping_charges" id="shippingCharges" class="form-control form-control-sm" value="0" step="0.01">
                        </div>
                        <div class="col-5 text-end pt-3">
                            <span class="fw-bold text-dark" id="displayShipping">₹ 0.00</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between pt-3 border-top border-2">
                        <h4 class="fw-bold mb-0">Grand Total</h4>
                        <h4 class="fw-bold mb-0 text-primary" id="grandTotal">₹ 0.00</h4>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow-lg">
                            <i class="bi bi-save-fill me-2"></i> SAVE & GENERATE
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
    .extra-small { font-size: 11px; }
    .btn-white { background: #fff; color: #1a202c; }
    .row-total { font-variant-numeric: tabular-nums; }
    .border-dashed { border-bottom-style: dashed !important; }
    
    @media (max-width: 767.98px) {
        #invoiceItems .item-row {
            display: flex;
            flex-wrap: wrap;
            padding: 1.25rem !important;
            margin-bottom: 1rem;
            background: #fff;
            border: 1px solid #edf2f7;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        #invoiceItems td {
            display: block;
            width: 100% !important;
            padding: 0.5rem 0 !important;
        }
        #invoiceItems td:nth-child(2), #invoiceItems td:nth-child(3),
        #invoiceItems td:nth-child(4), #invoiceItems td:nth-child(5) {
            width: 50% !important;
        }
        #invoiceItems td:nth-child(2), #invoiceItems td:nth-child(4) {
            padding-right: 0.5rem !important;
        }
        #invoiceItems td:nth-child(3), #invoiceItems td:nth-child(5) {
            padding-left: 0.5rem !important;
        }
        .remove-row {
            width: 100%;
            background: #fff5f5;
            color: #e53e3e !important;
            margin-top: 10px;
            border: 1px solid #feb2b2 !important;
            border-radius: 8px !important;
        }
    }
</style>

@endsection

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowCount = 1;

    // Add Row function
    function addNewRow() {
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
    }

    document.getElementById('addRow').addEventListener('click', addNewRow);
    document.getElementById('addRowMobile').addEventListener('click', addNewRow);

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
