<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('program_fees', function (Blueprint $table) {
            DB::statement("ALTER TABLE program_fees CHANGE COLUMN type type ENUM('percentage', 'amount', 'per amount') NULL DEFAULT 'percentage'");
            $table->double('per_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_fees', function (Blueprint $table) {
            DB::statement("ALTER TABLE program_fees CHANGE COLUMN type type ENUM('percentage', 'amount') NULL DEFAULT 'percentage'");
            $table->dropColumn('per_amount');
        });
    }
};
