<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    public $timestamps = false; // Using custom created_at

    protected $fillable = [
        'company_id',
        'product_id',
        'movement_type',
        'transaction_type',
        'reference_id',
        'reference_number',
        'movement_date',
        'quantity',
        'unit',
        'rate',
        'total_value',
        'stock_before',
        'stock_after',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'movement_date' => 'date',
        'quantity' => 'decimal:3',
        'rate' => 'decimal:2',
        'total_value' => 'decimal:2',
        'stock_before' => 'decimal:3',
        'stock_after' => 'decimal:3',
        'created_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
