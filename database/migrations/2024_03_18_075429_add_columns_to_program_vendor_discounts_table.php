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
            $table->bigInteger('from_day')->nullable();
            $table->bigInteger('to_day')->nullable();
            $table->string('limit_block_overdue_days')->nullable();
            $table->double('discount_on_posted_discount_spread')->nullable();
            $table->double('discount_on_posted_discount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_vendor_discounts', function (Blueprint $table) {
            $table->dropColumn('from_day');
            $table->dropColumn('to_day');
            $table->dropColumn('limit_block_overdue_days');
            $table->dropColumn('discount_on_posted_discount_spread');
            $table->dropColumn('discount_on_posted_discount');
        });
    }
};
