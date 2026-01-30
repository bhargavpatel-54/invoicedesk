@extends('layouts.app')

@section('title', 'Customers / Vendors')

@section('content')

<!-- Page Header -->
<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="mb-2 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-people-fill me-2"></i>Customer / Vendor Management
                </h5>
                <div class="d-flex gap-4 mt-2 small text-muted">
                    <span><i class="bi bi-circle-fill text-primary me-1" style="font-size: 8px;"></i>Total: <b class="text-dark">{{ $totalCount }}</b></span>
                    <span><i class="bi bi-circle-fill text-success me-1" style="font-size: 8px;"></i>Customer: <b class="text-dark">{{ $customerCount }}</b></span>
                    <span><i class="bi bi-circle-fill text-warning me-1" style="font-size: 8px;"></i>Vendor: <b class="text-dark">{{ $vendorCount }}</b></span>
                </div>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <a href="{{ route('customers.export', request()->all()) }}" class="btn btn-white border shadow-sm btn-sm">
                    <i class="bi bi-file-earmark-excel me-1 text-success"></i> Export to Excel
                </a>
                <form action="{{ route('customers.index') }}" method="GET" class="d-flex gap-1 mb-0">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search..." style="width: 150px;">
                    <select name="type" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 120px;">
                        <option value="">All Types</option>
                        <option value="customer" {{ request('type') == 'customer' ? 'selected' : '' }}>Customers</option>
                        <option value="vendor" {{ request('type') == 'vendor' ? 'selected' : '' }}>Vendors</option>
                    </select>
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <button type="submit" class="btn btn-white border shadow-sm btn-sm">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                <a href="{{ route('customers.create') }}" class="btn btn-primary text-white btn-sm px-3 fw-semibold shadow">
                    <i class="bi bi-plus-lg me-1"></i> Add New
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

<!-- List Table -->
<div class="card border-0 shadow-sm card-dashboard">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light fs-7 text-muted border-top-0">
                <tr>
                    <th class="ps-4" style="width: 40px;">
                        <input class="form-check-input" type="checkbox">
                    </th>
                    <th class="fw-semibold">Name</th>
                    <th class="fw-semibold">Contact Person</th>
                    <th class="fw-semibold">Type</th>
                    <th class="fw-semibold">State</th>
                    <th class="fw-semibold">Phone</th>
                    <th class="text-end pe-4 fw-semibold">Action</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                @forelse($customers as $customer)
                <tr>
                    <td class="ps-4">
                        <input class="form-check-input" type="checkbox">
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $customer->business_name }}</div>
                        @if($customer->gst_no)
                            <div class="text-muted small" style="font-size: 10px;">GST: {{ $customer->gst_no }}</div>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $customer->contact_person }}</td>
                    <td>
                        @if($customer->type == 'customer')
                            <span class="badge rounded-pill px-3 py-2" style="background: linear-gradient(135deg, rgba(0, 200, 83, 0.15), rgba(0, 230, 118, 0.15)); color: #00c853; font-weight: 600;">
                                Customer
                            </span>
                        @else
                            <span class="badge rounded-pill px-3 py-2" style="background: linear-gradient(135deg, rgba(255, 193, 7, 0.15), rgba(255, 179, 0, 0.15)); color: #ffc107; font-weight: 600;">
                                Vendor
                            </span>
                        @endif
                    </td>
                    <td class="text-muted">{{ $customer->state }}</td>
                    <td class="text-muted">{{ $customer->phone }}</td>
                    <td class="text-end pe-4">
                        <div class="d-flex justify-content-end gap-1">
                            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-white border shadow-sm text-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-white border shadow-sm text-dark">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-white border shadow-sm text-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                        No records found matching your criteria.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="card-footer bg-white border-top-0 py-3">
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">Showing {{ $customers->firstItem() ?? 0 }} to {{ $customers->lastItem() ?? 0 }} of {{ $customers->total() }} entries</small>
            <div>
                {{ $customers->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

@endsection
