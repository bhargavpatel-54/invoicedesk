@extends('layouts.app')

@section('title', 'Sale Invoices')

@section('content')

<!-- Page Header -->
<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="mb-2 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #3b82f6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-file-earmark-text-fill me-2"></i>Sale Invoices
                </h5>
                <div class="d-flex gap-4 mt-2 small text-muted">
                    <span><i class="bi bi-circle-fill text-success me-1" style="font-size: 8px;"></i>Paid: <b class="text-dark">{{ $paidCount }}</b></span>
                    <span><i class="bi bi-circle-fill text-warning me-1" style="font-size: 8px;"></i>Pending: <b class="text-dark">{{ $pendingCount }}</b></span>
                    <span><i class="bi bi-circle-fill text-danger me-1" style="font-size: 8px;"></i>Overdue: <b class="text-dark">{{ $overdueCount }}</b></span>
                </div>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <form action="{{ route('invoices.index') }}" method="GET" class="d-flex gap-1 mb-0">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search..." style="width: 150px;">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 120px;">
                        <option value="">All Status</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
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
            <thead class="bg-light">
                <tr>
                    <th class="border-0 px-4 py-3 small text-muted uppercase fw-bold">Invoice #</th>
                    <th class="border-0 py-3 small text-muted uppercase fw-bold">Customer</th>
                    <th class="border-0 py-3 small text-muted uppercase fw-bold">Date</th>
                    <th class="border-0 py-3 small text-muted uppercase fw-bold text-end">Amount</th>
                    <th class="border-0 py-3 small text-muted uppercase fw-bold text-center">Status</th>
                    <th class="border-0 px-4 py-3 small text-muted uppercase fw-bold text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                <tr class="invoice-row">
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
                                {{ strtoupper($invoice->status) }}
                            </span>
                            
                            @if($invoice->status !== 'paid')
                            <button type="button" 
                                    class="btn btn-success btn-sm rounded-pill px-3 py-1" 
                                    style="font-size: 10px;"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#markPaidModal{{ $invoice->id }}">
                                <i class="bi bi-check-circle me-1"></i> Mark Paid
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
                                <li><a class="dropdown-item" href="{{ route('invoices.show', $invoice) }}"><i class="bi bi-eye me-2"></i> View / Print</a></li>
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
                    <i class="bi bi-check-circle-fill me-2"></i>Mark Invoice as Paid
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
                        <i class="bi bi-check-circle-fill me-1"></i>Confirm Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach


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

</style>

@endsection
