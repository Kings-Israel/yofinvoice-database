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
        Schema::create('cbs_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_request_id')->nullable()->references('id')->on('payment_requests')->onDelete('set null')->onUpdate('cascade');
            $table->string('debit_from_account')->nullable();
            $table->string('credit_to_account')->nullable();
            $table->string('amount')->nullable();
            $table->string('transaction_created_date')->nullable();
            $table->string('transaction_date')->nullable();
            $table->string('pay_date')->nullable();
            $table->string('transaction_reference')->nullable();
            $table->string('status')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('product')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cbs_transactions');
    }
};
