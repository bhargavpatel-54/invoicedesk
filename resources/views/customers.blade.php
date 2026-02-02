@extends('layouts.app')

@section('title', 'Customers / Vendors')

@section('content')

<!-- Page Header -->
<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <!-- Desktop Header (Big Screen Only) -->
        <div class="d-none d-md-flex justify-content-between align-items-center flex-wrap gap-3">
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
                    <i class="bi bi-file-earmark-excel me-1 text-success"></i> Export Excel
                </a>
                <form action="{{ route('customers.index') }}" method="GET" class="d-flex gap-1 mb-0">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search..." style="width: 150px;">
                    <select name="type" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 120px;">
                        <option value="">All Types</option>
                        <option value="customer" {{ request('type') == 'customer' ? 'selected' : '' }}>Customers</option>
                        <option value="vendor" {{ request('type') == 'vendor' ? 'selected' : '' }}>Vendors</option>
                    </select>
                    <button type="submit" class="btn btn-white border shadow-sm btn-sm">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                <a href="{{ route('customers.create') }}" class="btn btn-primary text-white btn-sm px-3 fw-semibold shadow">
                    <i class="bi bi-plus-lg me-1"></i> Add New
                </a>
            </div>
        </div>

        <!-- Mobile Header (Small Screen Only) -->
        <div class="d-md-none text-center">
            <div class="d-flex justify-content-between align-items-center mb-3 text-start">
                <h5 class="mb-0 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-people-fill me-2"></i>Contacts
                </h5>
                <a href="{{ route('customers.create') }}" class="btn btn-primary text-white btn-sm px-3 fw-semibold shadow">
                    <i class="bi bi-plus-lg me-1"></i> New
                </a>
            </div>
            
            <div class="d-flex gap-2 mb-3">
                <form action="{{ route('customers.index') }}" method="GET" class="d-flex gap-1 mb-0 flex-grow-1">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search...">
                    <button type="submit" class="btn btn-white border shadow-sm btn-sm">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                <select name="type" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 110px;">
                    <option value="">Type</option>
                    <option value="customer" {{ request('type') == 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="vendor" {{ request('type') == 'vendor' ? 'selected' : '' }}>Vendor</option>
                </select>
            </div>

            <div class="mb-3">
                <a href="{{ route('customers.export', request()->all()) }}" class="btn btn-white border shadow-sm btn-sm w-100 py-2">
                    <i class="bi bi-file-earmark-excel me-1 text-success"></i> Export to Excel
                </a>
            </div>

            <div class="d-flex justify-content-around small text-muted bg-light p-2 rounded-3">
                <span>Total: <b class="text-dark">{{ $totalCount }}</b></span>
                <span>Cust: <b class="text-dark">{{ $customerCount }}</b></span>
                <span>Vend: <b class="text-dark">{{ $vendorCount }}</b></span>
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
            <!-- Desktop Table Header -->
            <thead class="bg-light fs-7 text-muted border-top-0 d-none d-md-table-header-group">
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
                <!-- Desktop Row -->
                <tr class="d-none d-md-table-row">
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

                <!-- Mobile Card Layout (No Scroll) -->
                <tr class="d-md-none">
                    <td class="p-0">
                        <div class="p-3 border-bottom position-relative">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        @if($customer->type == 'customer')
                                            <span class="badge bg-success bg-opacity-10 text-success extra-small rounded-pill">CUSTOMER</span>
                                        @else
                                            <span class="badge bg-warning bg-opacity-10 text-warning extra-small rounded-pill">VENDOR</span>
                                        @endif
                                        <span class="text-muted extra-small uppercase fw-bold">{{ $customer->state }}</span>
                                    </div>
                                    <div class="fw-bold text-dark fs-6">{{ $customer->business_name }}</div>
                                    @if($customer->gst_no)
                                        <div class="text-muted extra-small mt-1">GST: {{ $customer->gst_no }}</div>
                                    @endif
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm rounded-circle shadow-sm" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                        <li><a class="dropdown-item" href="{{ route('customers.show', $customer) }}"><i class="bi bi-eye me-2"></i> View Profile</a></li>
                                        <li><a class="dropdown-item" href="{{ route('customers.edit', $customer) }}"><i class="bi bi-pencil me-2"></i> Edit Details</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Delete this contact?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i> Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="row g-2 mt-2 pt-2 border-top border-light">
                                <div class="col-6">
                                    <small class="text-muted d-block extra-small uppercase fw-bold">Contact Person</small>
                                    <span class="small fw-semibold">{{ $customer->contact_person }}</span>
                                </div>
                                <div class="col-6 text-end">
                                    <small class="text-muted d-block extra-small uppercase fw-bold">Phone No.</small>
                                    <a href="tel:{{ $customer->phone }}" class="small fw-bold text-primary text-decoration-none">{{ $customer->phone }}</a>
                                </div>
                            </div>
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
