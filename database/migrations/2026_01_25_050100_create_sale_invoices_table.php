<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sale_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers_vendors')->onDelete('restrict');
            $table->string('invoice_number', 50);
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->string('reference_number', 50)->nullable();
            $table->string('payment_terms', 100)->nullable();
            $table->enum('status', ['draft', 'pending', 'paid', 'partial', 'overdue', 'cancelled'])->default('pending');
            $table->decimal('subtotal', 15, 2);
            $table->enum('discount_type', ['percentage', 'fixed'])->default('fixed');
            $table->decimal('discount_value', 15, 2)->default(0.00);
            $table->decimal('discount_amount', 15, 2)->default(0.00);
            $table->decimal('tax_amount', 15, 2)->default(0.00);
            $table->decimal('shipping_charges', 15, 2)->default(0.00);
            $table->decimal('other_charges', 15, 2)->default(0.00);
            $table->decimal('round_off', 10, 2)->default(0.00);
            $table->decimal('total_amount', 15, 2);
            $table->decimal('paid_amount', 15, 2)->default(0.00);
            $table->decimal('balance_amount', 15, 2)->default(0.00);
            $table->text('notes')->nullable();
            $table->text('terms_conditions')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
            
            $table->unique(['company_id', 'invoice_number']);
            $table->index('company_id');
            $table->index('customer_id');
            $table->index('invoice_date');
            $table->index('status');
            $table->index('invoice_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_invoices');
    }
};
