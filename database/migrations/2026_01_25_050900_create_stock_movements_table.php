<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');
            $table->enum('movement_type', ['in', 'out', 'adjustment']);
            $table->string('transaction_type', 50);
            $table->bigInteger('reference_id')->nullable();
            $table->string('reference_number', 50)->nullable();
            $table->date('movement_date');
            $table->decimal('quantity', 15, 3);
            $table->string('unit', 50);
            $table->decimal('rate', 15, 2)->default(0.00);
            $table->decimal('total_value', 15, 2)->default(0.00);
            $table->decimal('stock_before', 15, 3);
            $table->decimal('stock_after', 15, 3);
            $table->text('notes')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('company_id');
            $table->index('product_id');
            $table->index('movement_date');
            $table->index('movement_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
