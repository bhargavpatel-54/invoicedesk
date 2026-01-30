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
        Schema::create('customers_vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->enum('type', ['customer', 'vendor'])->default('customer');
            $table->string('business_name');
            $table->string('contact_person');
            $table->string('email')->nullable();
            $table->string('phone', 15);
            $table->string('alternate_phone', 15)->nullable();
            $table->string('gst_no')->nullable();
            $table->string('pan_no', 20)->nullable();
            $table->text('billing_address');
            $table->text('shipping_address')->nullable();
            $table->string('city', 100);
            $table->string('state', 100);
            $table->string('pincode', 10);
            $table->string('country', 100)->default('India');
            $table->decimal('opening_balance', 15, 2)->default(0.00);
            $table->enum('balance_type', ['debit', 'credit'])->default('debit');
            $table->decimal('credit_limit', 15, 2)->default(0.00);
            $table->integer('credit_days')->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('company_id');
            $table->index('type');
            $table->index('state');
            $table->index('business_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers_vendors');
    }
};
