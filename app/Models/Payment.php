<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'company_id',
        'customer_id',
        'payment_type',
        'payment_number',
        'sale_invoice_id',
        'purchase_invoice_id',
        'payment_date',
        'amount',
        'payment_mode',
        'reference_number',
        'bank_name',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function saleInvoice()
    {
        return $this->belongsTo(SaleInvoice::class);
    }

    public function purchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class);
    }

    public function creator()
    {
        return $this->belongsTo(Company::class, 'created_by');
    }
}
