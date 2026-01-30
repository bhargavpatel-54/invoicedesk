<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleInvoiceItem extends Model
{
    protected $fillable = [
        'sale_invoice_id',
        'product_id',
        'description',
        'quantity',
        'unit',
        'rate',
        'discount_percentage',
        'discount_amount',
        'taxable_amount',
        'tax_rate',
        'tax_amount',
        'total_amount',
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'rate' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'taxable_amount' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    // Relationships
    public function saleInvoice(): BelongsTo
    {
        return $this->belongsTo(SaleInvoice::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Helper methods
    public function calculateAmounts()
    {
        // Base amount (quantity × rate)
        $baseAmount = $this->quantity * $this->rate;
        
        // Calculate discount
        if ($this->discount_percentage > 0) {
            $this->discount_amount = ($baseAmount * $this->discount_percentage) / 100;
        }
        
        // Taxable amount (after discount)
        $this->taxable_amount = $baseAmount - $this->discount_amount;
        
        // Calculate tax
        $this->tax_amount = ($this->taxable_amount * $this->tax_rate) / 100;
        
        // Total amount
        $this->total_amount = $this->taxable_amount + $this->tax_amount;
        
        $this->save();
    }

    protected static function boot()
    {
        parent::boot();
        
        static::saved(function ($item) {
            // Recalculate invoice totals when item is saved
            $item->saleInvoice->calculateTotals();
        });
        
        static::deleted(function ($item) {
            // Recalculate invoice totals when item is deleted
            $item->saleInvoice->calculateTotals();
        });
    }
}
