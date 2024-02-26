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
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('stage');
            $table->string('product')->default('Vendor Financing');
            $table->string('leadType')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Others'])->default('Others');
            $table->enum('martial_status', ['Single', 'Married', 'Divorced', 'Separated', 'Others'])->default('Others');
            $table->enum('lead_status', ['Hot', 'Reject', 'Cold', 'Opportunity', 'Others'])->default('Hot');
            $table->string('source')->nullable();
            $table->string('associated_user')->nullable();
            $table->string('interaction_type')->nullable();
            $table->string('action')->nullable();
            $table->string('owner')->nullable();
            $table->string('compaign')->nullable();
            $table->string('company');
            $table->string('contact_name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('whatsapp_phone_number')->nullable();
            $table->string('region');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
