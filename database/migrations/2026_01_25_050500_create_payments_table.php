<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained('customers_vendors')->onDelete('set null');
            $table->enum('payment_type', ['received', 'paid']);
            $table->string('payment_number', 50);
            $table->date('payment_date');
            $table->decimal('amount', 15, 2);
            $table->enum('payment_mode', ['cash', 'cheque', 'bank_transfer', 'upi', 'card', 'other'])->default('cash');
            $table->string('reference_number', 100)->nullable();
            $table->string('bank_name')->nullable();
            $table->foreignId('sale_invoice_id')->nullable()->constrained('sale_invoices')->onDelete('set null');
            $table->foreignId('purchase_invoice_id')->nullable()->constrained('purchase_invoices')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->timestamps();
            
            $table->unique(['company_id', 'payment_number']);
            $table->index('company_id');
            $table->index('customer_id');
            $table->index('payment_type');
            $table->index('payment_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
