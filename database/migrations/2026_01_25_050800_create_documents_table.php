<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('document_type', 100);
            $table->string('document_name');
            $table->string('document_number', 100)->nullable();
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('file_path');
            $table->string('file_type', 50)->nullable();
            $table->integer('file_size')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_important')->default(false);
            $table->integer('reminder_days')->nullable();
            $table->string('tags')->nullable();
            $table->bigInteger('uploaded_by')->nullable();
            $table->timestamps();
            
            $table->index('company_id');
            $table->index('document_type');
            $table->index('expiry_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
