<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'product_code',
        'sku',
        'barcode',
        'description',
        'category',
        'brand',
        'manufacturer',
        'unit',
        'hsn_code',
        'sac_code',
        'tax_rate',
        'tax_type',
        'purchase_price',
        'selling_price',
        'mrp',
        'discount_percentage',
        'opening_stock',
        'current_stock',
        'committed_stock',
        'available_stock',
        'min_stock_level',
        'max_stock_level',
        'reorder_quantity',
        'warehouse_location',
        'weight',
        'dimensions',
        'is_active',
        'is_featured',
        'allow_backorder',
        'image',
        'images',
        'attributes',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'allow_backorder' => 'boolean',
        'images' => 'array',
        'attributes' => 'array',
        'tax_rate' => 'decimal:2',
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'mrp' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'opening_stock' => 'decimal:3',
        'current_stock' => 'decimal:3',
        'committed_stock' => 'decimal:3',
        'available_stock' => 'decimal:3',
        'min_stock_level' => 'decimal:3',
        'max_stock_level' => 'decimal:3',
        'reorder_quantity' => 'decimal:3',
        'weight' => 'decimal:3',
    ];

    // Relationships
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function saleInvoiceItems(): HasMany
    {
        return $this->hasMany(SaleInvoiceItem::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock($query)
    {
        return $query->whereRaw('current_stock <= min_stock_level');
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('current_stock', '<=', 0);
    }

    // Helper methods
    public function updateAvailableStock()
    {
        $this->available_stock = $this->current_stock - $this->committed_stock;
        $this->save();
    }

    public function needsReorder()
    {
        return $this->current_stock <= $this->min_stock_level;
    }

    public function getProfitMargin()
    {
        if ($this->selling_price == 0) return 0;
        return (($this->selling_price - $this->purchase_price) / $this->selling_price) * 100;
    }

    public function getStockValue()
    {
        return $this->current_stock * $this->purchase_price;
    }

    public function calculateTax($amount)
    {
        if ($this->tax_type === 'inclusive') {
            // Tax is already included in the price
            return ($amount * $this->tax_rate) / (100 + $this->tax_rate);
        } else {
            // Tax to be added on top
            return ($amount * $this->tax_rate) / 100;
        }
    }
}
