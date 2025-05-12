<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Document Title
            $table->string('client_name')->nullable(); // Client Name / Organization
            $table->string('client')->nullable();
            $table->string('salesperson'); // Salesperson / Creator
            $table->string('type'); // Document Type (Offer, Invoice, Proposal)
            $table->string('status'); // Status (Draft, Sent, Approved)
            $table->date('validity_period')->nullable(); // Validity Period (if applicable)
            $table->string('file_url')->nullable(); // <-- Add this line
            $table->timestamps(); // Created Date
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_documents');
    }
};
