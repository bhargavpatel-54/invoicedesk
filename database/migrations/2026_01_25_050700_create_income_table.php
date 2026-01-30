<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('income', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->date('income_date');
            $table->string('category', 100);
            $table->string('sub_category', 100)->nullable();
            $table->decimal('amount', 15, 2);
            $table->enum('payment_mode', ['cash', 'cheque', 'bank_transfer', 'upi', 'card', 'other'])->default('cash');
            $table->string('reference_number', 100)->nullable();
            $table->foreignId('customer_id')->nullable()->constrained('customers_vendors')->onDelete('set null');
            $table->text('description')->nullable();
            $table->string('receipt_file')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurring_frequency', ['daily', 'weekly', 'monthly', 'yearly'])->nullable();
            $table->text('notes')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->timestamps();
            
            $table->index('company_id');
            $table->index('income_date');
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('income');
    }
};
