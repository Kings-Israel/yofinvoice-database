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
        Schema::table('cbs_transactions', function (Blueprint $table) {
            $table->string('debit_from_account_name')->nullable();
            $table->string('credit_to_account_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cbs_transactions', function (Blueprint $table) {
            $table->dropColumn('debit_from_account_name');
            $table->dropColumn('credit_to_account_name');
        });
    }
};
