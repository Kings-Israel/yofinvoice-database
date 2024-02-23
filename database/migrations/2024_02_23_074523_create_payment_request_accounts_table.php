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
        Schema::create('payment_request_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_request_id')->references('id')->on('payment_requests')->onDelete('cascade')->onUpdate('cascade');
            $table->string('account')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_request_accounts');
    }
};
