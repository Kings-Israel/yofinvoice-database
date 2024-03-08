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
            $table->bigInteger('stop_supply')->nullable();
            $table->boolean('buyer_invoice_approval_required')->default(false);
            $table->string('collection_account')->nullable();
            $table->string('factoring_payment_account')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('stop_supply');
            $table->dropColumn('buyer_invoice_approval_required');
            $table->dropColumn('collection_account');
            $table->dropColumn('factoring_payment_account');
        });
    }
};
