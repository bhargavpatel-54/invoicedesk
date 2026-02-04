<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleInvoiceController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); 
    })->name('dashboard');
    
    Route::get('/report', function () {
        return view('report'); 
    })->name('report');
    
    Route::get('/purchase-invoice', function () {
        return view('purchase-invoice'); 
    })->name('purchase-invoice');
    
    Route::get('/payment', function () {
        return view('payment'); 
    })->name('payment');
    
    Route::get('/expense-income', function () {
        return view('expense-income'); 
    })->name('expense-income');
    
    Route::get('/other-documents', function () {
        return view('other-documents'); 
    })->name('other-documents');
    
    Route::get('/settings', function () {
        return view('settings'); 
    })->name('settings');
    
    // Customer & Vendor Management
    Route::get('/customers/export', [CustomerController::class, 'export'])->name('customers.export');
    Route::resource('customers', CustomerController::class);
    
    // Product Management
    Route::post('/products/{product}/add-stock', [ProductController::class, 'addStock'])->name('products.add-stock');
    Route::resource('products', ProductController::class);
    
    // Invoice Management  
    Route::resource('invoices', SaleInvoiceController::class);
    Route::get('/invoices/{invoice}/print', [SaleInvoiceController::class, 'print'])->name('invoices.print');
    Route::get('/invoices/{invoice}/download', [SaleInvoiceController::class, 'download'])->name('invoices.download');
    Route::post('/invoices/{invoice}/mark-paid', [SaleInvoiceController::class, 'markAsPaid'])->name('invoices.mark-paid');
    
    // Payment Management
    Route::resource('payments', PaymentController::class);
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Subscription Routes (for blocked/expired companies)
Route::middleware('auth')->group(function () {
    Route::get('/subscription/expired', function () {
        return view('subscription.expired');
    })->name('subscription.expired');
    
    Route::get('/subscription/blocked', function () {
        return view('subscription.blocked');
    })->name('subscription.blocked');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    // EMERGENCY SETUP - Visit /admin/setup-live to create the admin account
    Route::get('/setup-live', function() {
        try {
            \App\Models\Admin::updateOrCreate(
                ['email' => 'admin@invoicedesk.com'],
                [
                    'name' => 'System Admin',
                    'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                ]
            );
            return "✅ Admin account is now active on the live database. <br><br> <a href='/admin/login'>Go to Login</a>";
        } catch (\Exception $e) {
            return "❌ Setup failed: " . $e->getMessage();
        }
    });

    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/company/{id}', [AdminController::class, 'viewCompany'])->name('admin.company.view');
        Route::delete('/company/{id}', [AdminController::class, 'deleteCompany'])->name('admin.company.delete');
        Route::post('/company/{id}/toggle-block', [AdminController::class, 'toggleBlock'])->name('admin.company.toggle-block');
        Route::post('/company/{id}/update-subscription', [AdminController::class, 'updateSubscription'])->name('admin.company.update-subscription');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    });
});


