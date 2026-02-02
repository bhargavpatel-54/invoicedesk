@extends('layouts.app')

@section('title', 'Settings - InvoiceDesk')

@section('content')

<!-- Page Header -->
<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <!-- Desktop Header (Big Screen Only) -->
        <div class="d-none d-md-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="mb-2 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-gear-fill me-2"></i>Application Settings
                </h5>
                <p class="text-muted small mb-0">Manage your company profile and preferences.</p>
            </div>
        </div>

        <!-- Mobile Header (Small Screen Only) -->
        <div class="d-md-none text-center">
            <h5 class="mb-0 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <i class="bi bi-gear-fill me-2"></i>Settings
            </h5>
        </div>
    </div>
</div>

<!-- Settings Cards -->
<div class="row g-4">
    <!-- Company Profile -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm card-dashboard h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                            style="width: 48px; height: 48px; background: linear-gradient(135deg, rgba(0, 200, 83, 0.1), rgba(0, 230, 118, 0.15));">
                        <i class="bi bi-building fs-4" style="color: #00c853;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Company Profile</h5>
                        <small class="text-muted">Update your company information</small>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-muted">Company Name</label>
                    <input type="text" class="form-control bg-light" value="{{ Auth::user()->company_name ?? 'SHAKTI FASTNERS' }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-muted">Email</label>
                    <input type="email" class="form-control bg-light" value="{{ Auth::user()->email ?? 'company@example.com' }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-muted">GST Number</label>
                    <input type="text" class="form-control bg-light" value="{{ Auth::user()->gst_no ?? 'N/A' }}" readonly>
                </div>
                <button class="btn btn-primary btn-sm px-4 shadow">
                    <i class="bi bi-pencil me-2"></i>Edit Profile
                </button>
            </div>
        </div>
    </div>

    <!-- Subscription Info -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm card-dashboard h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                            style="width: 48px; height: 48px; background: linear-gradient(135deg, rgba(33, 150, 243, 0.1), rgba(3, 169, 244, 0.15));">
                        <i class="bi bi-calendar-check fs-4" style="color: #2196f3;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Subscription</h5>
                        <small class="text-muted">Manage your subscription plan</small>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-muted">Current Plan</label>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-bold">ACTIVE</span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-muted">Subscription End Date</label>
                    <input type="text" class="form-control bg-light" value="{{ Auth::user()->subscription_end_date ? \Carbon\Carbon::parse(Auth::user()->subscription_end_date)->format('d M Y') : 'N/A' }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-muted">Days Remaining</label>
                    <input type="text" class="form-control bg-light" value="{{ Auth::user()->daysLeft() ?? 'N/A' }}" readonly>
                </div>
                <button class="btn btn-primary btn-sm px-4 shadow">
                    <i class="bi bi-arrow-repeat me-2"></i>Renew Subscription
                </button>
            </div>
        </div>
    </div>

    <!-- Preferences -->
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm card-dashboard">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                            style="width: 48px; height: 48px; background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 179, 0, 0.15));">
                        <i class="bi bi-sliders fs-4" style="color: #ffc107;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Preferences</h5>
                        <small class="text-muted">Customize your experience</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-muted">Financial Year</label>
                        <select class="form-select">
                            <option selected>F.Y. 2025-2026</option>
                            <option>F.Y. 2024-2025</option>
                            <option>F.Y. 2023-2024</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-muted">Currency</label>
                        <select class="form-select">
                            <option selected>INR (₹)</option>
                            <option>USD ($)</option>
                            <option>EUR (€)</option>
                        </select>
                    </div>
                </div>
                <button class="btn btn-primary btn-sm px-4 shadow">
                    <i class="bi bi-check-circle me-2"></i>Save Preferences
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
