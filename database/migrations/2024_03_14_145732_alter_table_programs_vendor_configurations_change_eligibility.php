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
        Schema::table('program_vendor_configurations', function (Blueprint $table) {
            $table->double('eligibility')->nullable()->change();
            $table->double('invoice_margin')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_vendor_configurations', function (Blueprint $table) {
            $table->bigInteger('eligibility')->nullable()->change();
            $table->bigInteger('invoice_margin')->nullable()->change();
        });
    }
};
