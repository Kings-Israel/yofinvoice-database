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
        Schema::table('programs', function (Blueprint $table) {
            $table->double('eligibility')->nullable()->change();
            $table->double('invoice_margin')->nullable()->change();
            $table->double('program_limit')->nullable()->change();
            $table->double('max_limit_per_account')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->bigInteger('eligibility')->nullable()->change();
            $table->bigInteger('invoice_margin')->nullable()->change();
            $table->bigInteger('max_limit_per_account')->nullable()->change();
            $table->bigInteger('program_limit')->nullable()->change();
        });
    }
};
