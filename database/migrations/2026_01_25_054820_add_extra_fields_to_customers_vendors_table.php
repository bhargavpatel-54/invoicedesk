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
        Schema::table('customers_vendors', function (Blueprint $table) {
            $table->string('address_2')->nullable()->after('billing_address');
            $table->string('landmark')->nullable()->after('address_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers_vendors', function (Blueprint $table) {
            $table->dropColumn(['address_2', 'landmark']);
        });
    }
};
