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
            $table->bigInteger('dealer_bearing')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_fees', function (Blueprint $table) {
            $table->dropColumn('dealer_bearing');
        });
    }
};
