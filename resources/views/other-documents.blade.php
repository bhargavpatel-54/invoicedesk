@extends('layouts.app')

@section('title', 'Other Documents')

@section('content')

<!-- Page Header -->
<div class="card border-0 shadow-sm card-dashboard mb-4">
    <div class="card-body p-4">
        <!-- Desktop Header (Big Screen Only) -->
        <div class="d-none d-md-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="mb-2 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-folder2-open me-2"></i>Other Documents
                </h5>
                <div class="d-flex gap-4 mt-2 small text-muted">
                    <span><i class="bi bi-circle-fill text-primary me-1" style="font-size: 8px;"></i>Total: <b class="text-dark">12</b></span>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-white border shadow-sm btn-sm"><i class="bi bi-upload me-1"></i> Upload</button>
                <button class="btn btn-primary text-white btn-sm px-3 fw-semibold shadow"><i class="bi bi-plus-lg me-1"></i> Add Document</button>
            </div>
        </div>

        <!-- Mobile Header (Small Screen Only) -->
        <div class="d-md-none">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 fw-bold" style="background: linear-gradient(135deg, #1a202c 0%, #00c853 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="bi bi-folder2-open me-2"></i>Docs
                </h5>
                <button class="btn btn-primary text-white btn-sm px-3 fw-semibold shadow"><i class="bi bi-upload"></i></button>
            </div>
            <div class="small text-muted bg-light p-2 rounded-3 text-center">
                Total Documents: <b class="text-dark">12</b>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm card-dashboard h-100">
            <div class="card-body p-4 text-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(255, 0, 0, 0.15)); box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);">
                    <i class="bi bi-file-pdf fs-1" style="color: #dc3545;"></i>
                </div>
                <h6 class="fw-bold mb-2">Company Registration</h6>
                <p class="text-muted small mb-3">PDF • 2.4 MB</p>
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-sm btn-white border shadow-sm">
                        <i class="bi bi-download"></i>
                    </button>
                    <button class="btn btn-sm btn-primary shadow">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm card-dashboard h-100">
            <div class="card-body p-4 text-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(33, 150, 243, 0.1), rgba(3, 169, 244, 0.15)); box-shadow: 0 4px 12px rgba(33, 150, 243, 0.2);">
                    <i class="bi bi-file-earmark-word fs-1" style="color: #2196f3;"></i>
                </div>
                <h6 class="fw-bold mb-2">GST Certificate</h6>
                <p class="text-muted small mb-3">DOCX • 1.2 MB</p>
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-sm btn-white border shadow-sm">
                        <i class="bi bi-download"></i>
                    </button>
                    <button class="btn btn-sm btn-primary shadow">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm card-dashboard h-100">
            <div class="card-body p-4 text-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(0, 200, 83, 0.1), rgba(0, 230, 118, 0.15)); box-shadow: 0 4px 12px rgba(0, 200, 83, 0.2);">
                    <i class="bi bi-file-earmark-image fs-1" style="color: #00c853;"></i>
                </div>
                <h6 class="fw-bold mb-2">Bank Statement</h6>
                <p class="text-muted small mb-3">PNG • 3.1 MB</p>
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-sm btn-white border shadow-sm">
                        <i class="bi bi-download"></i>
                    </button>
                    <button class="btn btn-sm btn-primary shadow">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
