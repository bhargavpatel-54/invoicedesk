@extends('layouts.app')

@section('title', 'Sale Invoices')

@section('content')

<!-- Page Header -->
<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <!-- Desktop Header (Big Screen Only) -->
        <div class="d-none d-md-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="mb-2 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #3b82f6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-file-earmark-text-fill me-2"></i>Sale Invoices
                </h5>
                <div class="d-flex gap-4 mt-2 small text-muted">
                    <span><i class="bi bi-circle-fill text-success me-1" style="font-size: 8px;"></i>Received: <b class="text-dark">{{ $paidCount }}</b></span>
                    <span><i class="bi bi-circle-fill text-warning me-1" style="font-size: 8px;"></i>Pending: <b class="text-dark">{{ $pendingCount }}</b></span>
                    <span><i class="bi bi-circle-fill text-danger me-1" style="font-size: 8px;"></i>Overdue: <b class="text-dark">{{ $overdueCount }}</b></span>
                </div>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <form action="{{ route('invoices.index') }}" method="GET" class="d-flex gap-1 mb-0">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search..." style="width: 150px;">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 120px;">
                        <option value="">All Status</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Received</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                    </select>
                    <button type="submit" class="btn btn-white border shadow-sm btn-sm">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                <a href="{{ route('invoices.create') }}" class="btn btn-primary text-white btn-sm px-3 fw-semibold shadow">
                    <i class="bi bi-plus-lg me-1"></i> New Invoice
                </a>
            </div>
        </div>

        <!-- Mobile Header (Small Screen Only) -->
        <div class="d-md-none">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #3b82f6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-file-earmark-text-fill me-2"></i>Invoices
                </h5>
                <a href="{{ route('invoices.create') }}" class="btn btn-primary text-white btn-sm px-3 fw-semibold shadow">
                    <i class="bi bi-plus-lg me-1"></i> New
                </a>
            </div>
            <div class="d-flex gap-2 mb-3">
                <form action="{{ route('invoices.index') }}" method="GET" class="d-flex gap-1 mb-0 flex-grow-1">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search...">
                    <button type="submit" class="btn btn-white border shadow-sm btn-sm">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 110px;">
                    <option value="">Status</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Received</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                </select>
            </div>
            <div class="d-flex justify-content-around small text-muted bg-light p-2 rounded-3">
                <span>Received: <b class="text-dark">{{ $paidCount }}</b></span>
                <span>Pending: <b class="text-dark">{{ $pendingCount }}</b></span>
                <span>Overdue: <b class="text-dark">{{ $overdueCount }}</b></span>
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

<!-- Invoices Table -->
<div class="card border-0 shadow-sm card-dashboard">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light d-none d-md-table-header-group">
                <tr>
                    <th class="border-0 px-4 py-3 small text-muted uppercase fw-bold">Invoice #</th>
                    <th class="border-0 py-3 small text-muted uppercase fw-bold">Customer</th>
                    <th class="border-0 py-3 small text-muted uppercase fw-bold">Date</th>
                    <th class="border-0 py-3 small text-muted uppercase fw-bold text-end">Amount</th>
                    <th class="border-0 py-3 small text-muted uppercase fw-bold text-center">Status</th>
                    <th class="border-0 px-4 py-3 small text-muted uppercase fw-bold text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="invoice-list-body">
                @forelse($invoices as $invoice)
                <tr class="invoice-row d-none d-md-table-row">
                    <td class="px-4">
                        <a href="{{ route('invoices.show', $invoice) }}" class="fw-bold text-primary text-decoration-none">
                            {{ $invoice->invoice_number }}
                        </a>
                        @if($invoice->reference_number)
                            <small class="d-block text-muted">Ref: {{ $invoice->reference_number }}</small>
                        @endif
                    </td>
                    <td>
                        <div class="fw-medium text-dark">{{ $invoice->customer->business_name }}</div>
                        <small class="text-muted">{{ $invoice->customer->phone }}</small>
                    </td>
                    <td>
                        <div class="text-dark small">{{ $invoice->invoice_date->format('d M Y') }}</div>
                        <small class="text-muted" style="font-size: 10px;">Due: {{ $invoice->due_date->format('d M Y') }}</small>
                    </td>
                    <td class="text-end fw-bold text-dark">
                        ₹ {{ number_format($invoice->total_amount, 2) }}
                    </td>
                    <td class="text-center">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            @php
                                $statusClass = match($invoice->status) {
                                    'paid' => 'bg-success',
                                    'pending', 'draft' => 'bg-warning text-dark',
                                    'partial' => 'bg-info',
                                    'overdue' => 'bg-danger',
                                    'cancelled' => 'bg-secondary',
                                    default => 'bg-primary'
                                };
                            @endphp
                            <span class="badge {{ $statusClass }} rounded-pill px-3 py-1 fw-medium" style="font-size: 10px;">
                                {{ $invoice->status === 'paid' ? 'RECEIVED' : strtoupper($invoice->status) }}
                            </span>
                            
                            @if($invoice->status !== 'paid')
                            <button type="button" 
                                    class="btn btn-success btn-sm rounded-pill px-3 py-1" 
                                    style="font-size: 10px;"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#markPaidModal{{ $invoice->id }}">
                                <i class="bi bi-check-circle me-1"></i> Mark Received
                            </button>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 text-end">
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li><a class="dropdown-item view-invoice-btn" href="#" data-invoice-id="{{ $invoice->id }}" data-invoice-url="{{ route('invoices.show', $invoice) }}"><i class="bi bi-eye me-2"></i> View / Print</a></li>
                                <li><a class="dropdown-item" href="{{ route('invoices.download', $invoice) }}"><i class="bi bi-file-earmark-pdf-fill me-2 text-success"></i> Download PDF</a></li>
                                <li><a class="dropdown-item" href="{{ route('invoices.edit', $invoice) }}"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" onsubmit="return confirm('Archive/Delete this invoice? Stock will be reversed.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i> Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>

                <!-- Mobile Card View -->
                <tr class="d-md-none">
                    <td colspan="6" class="p-0">
                        <div class="mobile-invoice-card p-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <a href="#" class="fw-bold text-primary text-decoration-none view-invoice-btn" 
                                       data-invoice-id="{{ $invoice->id }}" data-invoice-url="{{ route('invoices.show', $invoice) }}">
                                        {{ $invoice->invoice_number }}
                                    </a>
                                    <div class="small fw-medium text-dark mt-1">{{ $invoice->customer->business_name }}</div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                        <li><a class="dropdown-item view-invoice-btn" href="#" data-invoice-id="{{ $invoice->id }}" data-invoice-url="{{ route('invoices.show', $invoice) }}"><i class="bi bi-eye me-2"></i> View / Print</a></li>
                                        <li><a class="dropdown-item" href="{{ route('invoices.download', $invoice) }}"><i class="bi bi-file-earmark-pdf-fill me-2 text-success"></i> Download PDF</a></li>
                                        <li><a class="dropdown-item" href="{{ route('invoices.edit', $invoice) }}"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" onsubmit="return confirm('Archive/Delete this invoice?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i> Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="small text-muted">
                                    {{ $invoice->invoice_date->format('d M Y') }}
                                </div>
                                <div class="fw-bold text-dark">
                                    ₹ {{ number_format($invoice->total_amount, 2) }}
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="badge {{ $statusClass }} rounded-pill px-3 py-1 fw-medium" style="font-size: 10px;">
                                    {{ $invoice->status === 'paid' ? 'RECEIVED' : strtoupper($invoice->status) }}
                                </span>
                                @if($invoice->status !== 'paid')
                                <button type="button" 
                                        class="btn btn-success btn-sm rounded-pill px-3 py-1" 
                                        style="font-size: 10px;"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#markPaidModal{{ $invoice->id }}">
                                    <i class="bi bi-check-circle me-1"></i> Mark Received
                                </button>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                
                @empty
                <tr>
                    <td colspan="6" class="py-5 text-center text-muted">
                        <i class="bi bi-file-earmark-text fs-1 d-block mb-3 opacity-25"></i>
                        No invoices found. <a href="{{ route('invoices.create') }}">Create your first invoice</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($invoices->hasPages())
    <div class="card-footer bg-white border-0 px-4 py-3">
        {{ $invoices->links() }}
    </div>
    @endif
</div>

<!-- Mark as Paid Modals (Outside Table) -->
@foreach($invoices as $invoice)
@if($invoice->status !== 'paid')
<div class="modal fade" id="markPaidModal{{ $invoice->id }}" tabindex="-1" aria-labelledby="markPaidModalLabel{{ $invoice->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white border-0">
                <h5 class="modal-title" id="markPaidModalLabel{{ $invoice->id }}">
                    <i class="bi bi-check-circle-fill me-2"></i>Mark Invoice as Received
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('invoices.mark-paid', $invoice) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <p class="text-muted mb-3">
                            <strong>Invoice:</strong> {{ $invoice->invoice_number }}<br>
                            <strong>Customer:</strong> {{ $invoice->customer->business_name }}<br>
                            <strong>Amount:</strong> ₹{{ number_format($invoice->total_amount, 2) }}
                        </p>
                    </div>
                    <div class="mb-3">
                        <label for="payment_date{{ $invoice->id }}" class="form-label fw-semibold">
                            <i class="bi bi-calendar-event me-1"></i>Payment Received Date *
                        </label>
                        <input type="date" 
                               class="form-control form-control-lg" 
                               id="payment_date{{ $invoice->id }}" 
                               name="payment_date" 
                               value="{{ date('Y-m-d') }}" 
                               max="{{ date('Y-m-d') }}"
                               required>
                        <small class="text-muted">Select the date when payment was received</small>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle-fill me-1"></i>Confirm Received
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach

<!-- Invoice View Modal -->
<div class="modal fade" id="invoiceViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0 shadow-2xl floating-modal">
            <div class="modal-header border-0 bg-white px-4 py-3 d-flex justify-content-between align-items-center">
                <h5 class="modal-title fw-bold text-dark mb-0">Invoice Preview</h5>
                <div class="d-flex gap-2">
                    <button id="modalPrintBtn" class="btn btn-primary btn-sm px-3 shadow-sm">
                        <i class="bi bi-printer me-1"></i> Print
                    </button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body p-0 bg-light position-relative">
                <div id="modalLoading" class="position-absolute top-50 start-50 translate-middle text-center" style="display: none; z-index: 10;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <iframe id="invoiceIframe" src="" frameborder="0" style="width: 100%; height: 80vh; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-invoice-btn');
    const modal = new bootstrap.Modal(document.getElementById('invoiceViewModal'));
    const iframe = document.getElementById('invoiceIframe');
    const loading = document.getElementById('modalLoading');
    const printBtn = document.getElementById('modalPrintBtn');
    
    viewButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('data-invoice-url');
            iframe.src = url;
            loading.style.display = 'block';
            modal.show();
            
            iframe.onload = function() {
                loading.style.display = 'none';
            };
        });
    });
    
    printBtn.addEventListener('click', function() {
        iframe.contentWindow.print();
    });

    // Reset iframe on modal close
    document.getElementById('invoiceViewModal').addEventListener('hidden.bs.modal', function () {
        iframe.src = '';
    });
});
</script>
@endsection


<style>
    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
    .card-dashboard { border-radius: 12px; position: relative; z-index: 1; }
    
    /* Fix dropdown clipping and style */
    .table-responsive { 
        overflow: visible !important;
        position: relative;
        min-height: 500px; /* Set a larger default height */
    }
    
    .card-dashboard {
        padding-bottom: 2rem; /* Add bottom spacing to the card */
    }
    
    .table td {
        position: relative;
    }

    .dropdown-menu { 
        z-index: 9999 !important; /* Extremely high z-index */
        border: none !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
        border-radius: 10px !important;
        margin-top: 5px !important;
    }
    
    .dropdown-item {
        padding: 0.6rem 1.2rem;
        font-size: 0.875rem;
        color: #4a5568;
        transition: all 0.2s;
    }

    .dropdown-item:hover {
        background-color: #f7fafc;
        color: #3182ce;
        padding-left: 1.4rem;
    }
    
    .dropdown-item i {
        width: 24px;
        text-align: center;
        font-size: 1rem;
    }
    
    .invoice-row:hover {
        background-color: rgba(59, 130, 246, 0.03) !important;
    }

    /* Modal styling */
    .modal {
        z-index: 10000 !important;
    }
    
    .modal-backdrop {
        z-index: 9999 !important;
    }
    
    .modal-content {
        border-radius: 15px !important;
    }
    
    .modal-header.bg-success {
        border-top-left-radius: 15px !important;
        border-top-right-radius: 15px !important;
    }

    /* Floating effect for modal */
    .floating-modal {
        animation: floatIn 0.4s ease-out;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
    }

    @keyframes floatIn {
        0% { opacity: 0; transform: translateY(30px) scale(0.98); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    /* Mobile responsiveness tweaks */
    @media (max-width: 768px) {
        .card-body.p-4 { padding: 1.25rem !important; }
        .header-main-content h5 { font-size: 1.1rem; }
        .table-responsive { min-height: auto !important; }
        .invoice-list-body tr:last-child .mobile-invoice-card { border-bottom: none; }
        .floating-modal { width: 95vw; margin: auto; }
        #invoiceIframe { height: 70vh; }
    }

    .mobile-invoice-card {
        transition: background-color 0.2s;
    }
    
    .mobile-invoice-card:active {
        background-color: #f8f9fa;
    }

</style>

@endsection
