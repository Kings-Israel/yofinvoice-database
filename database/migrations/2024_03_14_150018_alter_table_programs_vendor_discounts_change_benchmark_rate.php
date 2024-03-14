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
        Schema::table('program_vendor_discounts', function (Blueprint $table) {
            $table->double('benchmark_rate')->nullable()->change();
            $table->double('business_strategy_spread')->nullable()->change();
            $table->double('credit_spread')->nullable()->change();
            $table->double('total_spread')->nullable()->change();
            $table->double('total_roi')->nullable()->change();
            $table->double('anchor_discount_bearing')->nullable()->change();
            $table->double('vendor_discount_bearing')->nullable()->change();
            $table->double('penal_discount_on_principle')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_vendor_discounts', function (Blueprint $table) {
            $table->bigInteger('benchmark_rate')->nullable()->change();
            $table->bigInteger('business_strategy_spread')->nullable()->change();
            $table->bigInteger('credit_spread')->nullable()->change();
            $table->bigInteger('total_spread')->nullable()->change();
            $table->bigInteger('total_roi')->nullable()->change();
            $table->bigInteger('anchor_discount_bearing')->nullable()->change();
            $table->bigInteger('vendor_discount_bearing')->nullable()->change();
            $table->bigInteger('penal_discount_on_principle')->nullable()->change();
        });
    }
};
