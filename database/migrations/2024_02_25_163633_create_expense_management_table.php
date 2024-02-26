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
        Schema::create('expense_management', function (Blueprint $table) {
            $table->id();
            $table->string('approved_by')->nullable();
            $table->string('lead_name');
            $table->string('activity');
            $table->string('status')->default('pending');
            $table->string('amount');
            $table->date('request_date');
            $table->string('document')->nullable();
            $table->text('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_management');
    }
};
