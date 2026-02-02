@extends('layouts.app')

@section('title', 'Customers & Vendors')

@section('content')

<!-- Page Header -->
<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <!-- Desktop Header (Big Screen Only) -->
        <div class="d-none d-md-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="mb-2 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-people-fill me-2"></i>Customers & Vendors
                </h5>
                <div class="d-flex gap-4 mt-2 small text-muted">
                    <span><i class="bi bi-circle-fill text-primary me-1" style="font-size: 8px;"></i>Total: <b class="text-dark">{{ $totalCount }}</b></span>
                    <span><i class="bi bi-circle-fill text-success me-1" style="font-size: 8px;"></i>Customer: <b class="text-dark">{{ $customerCount }}</b></span>
                    <span><i class="bi bi-circle-fill text-warning me-1" style="font-size: 8px;"></i>Vendor: <b class="text-dark">{{ $vendorCount }}</b></span>
                </div>
            </div>
            <div class="d-flex gap-2 align-items-center">
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

<!-- Customers Table -->
<div class="card border-0 shadow-sm card-dashboard">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light d-none d-md-table-header-group">
                <tr>
                    <th class="border-0 px-4 py-3 small text-muted uppercase fw-bold">Type</th>
                    <th class="border-0 py-3 small text-muted uppercase fw-bold">Business Name</th>
                    <th class="border-0 py-3 small text-muted uppercase fw-bold">Contact</th>
                    <th class="border-0 py-3 small text-muted uppercase fw-bold">Location</th>
                    <th class="border-0 py-3 small text-muted uppercase fw-bold text-center">Status</th>
                    <th class="border-0 px-4 py-3 small text-muted uppercase fw-bold text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="contact-list-body">
                @forelse($customers as $customer)
                <tr class="contact-row d-none d-md-table-row">
                    <td class="px-4">
                        <span class="badge {{ $customer->type === 'customer' ? 'bg-info' : 'bg-purple' }} rounded-pill px-3 py-1 fw-medium" style="font-size: 10px; {{ $customer->type === 'vendor' ? 'background-color: #6f42c1 !important;' : '' }}">
                            {{ strtoupper($customer->type) }}
                        </span>
                    </td>
                    <td>
                        <div class="fw-bold text-dark">{{ $customer->business_name }}</div>
                        @if($customer->gst_no)
                            <small class="text-muted">GST: {{ $customer->gst_no }}</small>
                        @endif
                    </td>
                    <td>
                        <div class="text-dark small"><i class="bi bi-person me-1"></i>{{ $customer->contact_person }}</div>
                        <small class="text-muted"><i class="bi bi-phone me-1"></i>{{ $customer->phone }}</small>
                    </td>
                    <td>
                        <div class="text-dark small">{{ $customer->city }}</div>
                        <small class="text-muted">{{ $customer->state }}</small>
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $customer->is_active ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-1 fw-medium" style="font-size: 10px;">
                            {{ $customer->is_active ? 'ACTIVE' : 'INACTIVE' }}
                        </span>
                    </td>
                    <td class="px-4 text-end">
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li><a class="dropdown-item" href="{{ route('customers.edit', $customer) }}"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this {{ $customer->type }}?');">
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
                        <div class="mobile-contact-card p-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="badge {{ $customer->type === 'customer' ? 'bg-info' : 'bg-purple' }} rounded-pill px-2 py-1 fw-medium mb-2" style="font-size: 9px; {{ $customer->type === 'vendor' ? 'background-color: #6f42c1 !important;' : '' }}">
                                        {{ strtoupper($customer->type) }}
                                    </span>
                                    <div class="fw-bold text-dark">{{ $customer->business_name }}</div>
                                    <div class="small text-muted mt-1">
                                        <i class="bi bi-person me-1"></i>{{ $customer->contact_person }}
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                        <li><a class="dropdown-item" href="{{ route('customers.edit', $customer) }}"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i> Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="small text-muted">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $customer->city }}
                                </div>
                                <span class="badge {{ $customer->is_active ? 'bg-success' : 'bg-danger' }} rounded-pill px-2 py-1 fw-medium" style="font-size: 9px;">
                                    {{ $customer->is_active ? 'ACTIVE' : 'INACTIVE' }}
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>
                
                @empty
                <tr>
                    <td colspan="6" class="py-5 text-center text-muted">
                        <i class="bi bi-people fs-1 d-block mb-3 opacity-25"></i>
                        No customers or vendors found. <a href="{{ route('customers.create') }}">Add your first one</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($customers->hasPages())
    <div class="card-footer bg-white border-0 px-4 py-3">
        {{ $customers->links() }}
    </div>
    @endif
</div>

<style>
    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
    .card-dashboard { border-radius: 12px; position: relative; z-index: 1; }
    
    .table-responsive { 
        overflow: visible !important;
        position: relative;
    }
    
    .dropdown-menu { 
        z-index: 9999 !important;
        border: none !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
        border-radius: 10px !important;
    }
    
    .contact-row:hover {
        background-color: rgba(59, 130, 246, 0.03) !important;
    }

    @media (max-width: 768px) {
        .card-body.p-4 { padding: 1.25rem !important; }
        .mobile-contact-card { transition: background-color 0.2s; }
        .mobile-contact-card:active { background-color: #f8f9fa; }
    }
</style>

@endsection
