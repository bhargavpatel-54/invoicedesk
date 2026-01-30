<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('setting_key', 100);
            $table->text('setting_value')->nullable();
            $table->enum('setting_type', ['string', 'number', 'boolean', 'json'])->default('string');
            $table->string('description')->nullable();
            $table->boolean('is_system')->default(false);
            $table->timestamps();
            
            $table->unique(['company_id', 'setting_key']);
            $table->index('company_id');
            $table->index('setting_key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
