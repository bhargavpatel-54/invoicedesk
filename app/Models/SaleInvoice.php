<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleInvoice extends Model
{
    protected $fillable = [
        'company_id',
        'customer_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'reference_number',
        'payment_terms',
        'status',
        'subtotal',
        'discount_type',
        'discount_value',
        'discount_amount',
        'tax_amount',
        'shipping_charges',
        'other_charges',
        'round_off',
        'total_amount',
        'paid_amount',
        'balance_amount',
        'paid_date',
        'notes',
        'terms_conditions',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'paid_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_charges' => 'decimal:2',
        'other_charges' => 'decimal:2',
        'round_off' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance_amount' => 'decimal:2',
    ];

    // Accessor to automatically determine status
    public function getStatusAttribute($value)
    {
        // If already paid, return paid
        if ($value === 'paid') {
            return 'paid';
        }

        // Check if overdue (due date passed and not paid)
        if ($this->due_date && $this->due_date->isPast() && $value !== 'paid') {
            return 'overdue';
        }

        // Return the stored status
        return $value;
    }

    // Relationships
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleInvoiceItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue')
                    ->orWhere(function($q) {
                        $q->where('due_date', '<', now())
                          ->whereIn('status', ['pending', 'partial']);
                    });
    }

    // Helper methods
    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function isOverdue()
    {
        return $this->due_date < now() && !$this->isPaid();
    }

    public function updatePaymentStatus()
    {
        if ($this->balance_amount <= 0) {
            $this->status = 'paid';
        } elseif ($this->paid_amount > 0) {
            $this->status = 'partial';
        } elseif ($this->isOverdue()) {
            $this->status = 'overdue';
        } else {
            $this->status = 'pending';
        }
        $this->save();
    }

    public function calculateTotals()
    {
        // Calculate subtotal from items
        $this->subtotal = $this->items->sum('total_amount');
        
        // Calculate discount
        if ($this->discount_type === 'percentage') {
            $this->discount_amount = ($this->subtotal * $this->discount_value) / 100;
        } else {
            $this->discount_amount = $this->discount_value;
        }
        
        // Calculate taxable amount
        $taxableAmount = $this->subtotal - $this->discount_amount;
        
        // Tax is calculated from items
        $this->tax_amount = $this->items->sum('tax_amount');
        
        // Calculate total
        $this->total_amount = $taxableAmount + $this->tax_amount + $this->shipping_charges + $this->other_charges + $this->round_off;
        
        // Update balance
        $this->balance_amount = $this->total_amount - $this->paid_amount;
        
        $this->save();
    }

    public static function generateInvoiceNumber($companyId)
    {
        // Get company to determine financial year start month
        $company = Company::find($companyId);
        $fyStartMonth = $company->financial_year_start_month ?? 4; // Default to April
        
        // Calculate current financial year
        $currentDate = now();
        $currentMonth = $currentDate->month;
        $currentYear = $currentDate->year;
        
        // If current month is before FY start month, we're in the previous FY
        if ($currentMonth < $fyStartMonth) {
            $fyStartYear = $currentYear - 1;
            $fyEndYear = $currentYear;
        } else {
            $fyStartYear = $currentYear;
            $fyEndYear = $currentYear + 1;
        }
        
        // Create FY start and end dates
        $fyStart = \Carbon\Carbon::create($fyStartYear, $fyStartMonth, 1)->startOfDay();
        $fyEnd = \Carbon\Carbon::create($fyEndYear, $fyStartMonth, 1)->subDay()->endOfDay();
        
        // Get the last invoice number for this company in the current financial year
        $lastInvoice = static::where('company_id', $companyId)
                            ->whereBetween('invoice_date', [$fyStart, $fyEnd])
                            ->orderBy('id', 'desc')
                            ->first();
        
        // Start from 1 and auto-increment
        $number = 1;
        if ($lastInvoice) {
            // Extract the numeric part from the invoice number
            preg_match('/(\d+)$/', $lastInvoice->invoice_number, $matches);
            if (isset($matches[1])) {
                $number = intval($matches[1]) + 1;
            }
        }
        
        // Return simple number (1, 2, 3, etc.)
        return (string) $number;
    }
}
