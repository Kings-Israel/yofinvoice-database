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
        Schema::table('program_fees', function (Blueprint $table) {
            $table->double('value')->nullable()->change();
            $table->double('anchor_bearing_discount')->nullable()->change();
            $table->double('vendor_bearing_discount')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_fees', function (Blueprint $table) {
            $table->bigInteger('value')->nullable()->change();
            $table->bigInteger('anchor_bearing_discount')->nullable()->change();
            $table->bigInteger('vendor_bearing_discount')->nullable()->change();
        });
    }
};
