<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $table = 'customers_vendors';
    
    protected $fillable = [
        'company_id',
        'type',
        'business_name',
        'contact_person',
        'email',
        'phone',
        'alternate_phone',
        'gst_no',
        'pan_no',
        'billing_address',
        'address_2',
        'landmark',
        'shipping_address',
        'city',
        'state',
        'pincode',
        'country',
        'opening_balance',
        'balance_type',
        'credit_limit',
        'credit_days',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'opening_balance' => 'decimal:2',
        'credit_limit' => 'decimal:2',
        'credit_days' => 'integer',
    ];

    // Relationships
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function saleInvoices(): HasMany
    {
        return $this->hasMany(SaleInvoice::class, 'customer_id');
    }

    public function purchaseInvoices(): HasMany
    {
        return $this->hasMany(PurchaseInvoice::class, 'vendor_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    // Scopes
    public function scopeCustomers($query)
    {
        return $query->where('type', 'customer');
    }

    public function scopeVendors($query)
    {
        return $query->where('type', 'vendor');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper methods
    public function isCustomer()
    {
        return $this->type === 'customer';
    }

    public function isVendor()
    {
        return $this->type === 'vendor';
    }

    public function getCurrentBalance()
    {
        // Calculate current balance based on invoices and payments
        // This will be implemented with business logic
        return $this->opening_balance;
    }
}
