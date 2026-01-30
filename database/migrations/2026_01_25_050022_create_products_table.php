<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('name');
            $table->string('product_code', 50)->nullable();
            $table->string('sku', 100)->nullable();
            $table->string('barcode', 100)->nullable();
            $table->text('description')->nullable();
            $table->string('category', 100)->nullable();
            $table->string('brand', 100)->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('unit', 50)->default('pcs');
            $table->string('hsn_code', 20)->nullable();
            $table->string('sac_code', 20)->nullable();
            $table->decimal('tax_rate', 5, 2)->default(18.00);
            $table->enum('tax_type', ['inclusive', 'exclusive'])->default('exclusive');
            $table->decimal('purchase_price', 15, 2)->default(0.00);
            $table->decimal('selling_price', 15, 2);
            $table->decimal('mrp', 15, 2)->nullable();
            $table->decimal('discount_percentage', 5, 2)->default(0.00);
            $table->decimal('opening_stock', 15, 3)->default(0.000);
            $table->decimal('current_stock', 15, 3)->default(0.000);
            $table->decimal('committed_stock', 15, 3)->default(0.000);
            $table->decimal('available_stock', 15, 3)->default(0.000);
            $table->decimal('min_stock_level', 15, 3)->default(0.000);
            $table->decimal('max_stock_level', 15, 3)->nullable();
            $table->decimal('reorder_quantity', 15, 3)->nullable();
            $table->string('warehouse_location', 100)->nullable();
            $table->decimal('weight', 10, 3)->nullable();
            $table->string('dimensions', 100)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('allow_backorder')->default(false);
            $table->string('image')->nullable();
            $table->json('images')->nullable();
            $table->json('attributes')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('company_id');
            $table->index('name');
            $table->index('category');
            $table->index('brand');
            $table->index('barcode');
            $table->index('is_active');
            
            // Unique constraints
            $table->unique(['company_id', 'product_code']);
            $table->unique(['company_id', 'sku']);
            $table->unique(['company_id', 'barcode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
