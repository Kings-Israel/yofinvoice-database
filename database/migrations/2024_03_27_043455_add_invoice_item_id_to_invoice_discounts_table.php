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
        Schema::table('invoice_discounts', function (Blueprint $table) {
            $table->foreignId('invoice_item_id')->nullable()->references('id')->on('invoice_items')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_discounts', function (Blueprint $table) {
            $table->dropColumn('invoice_item_id');
        });
    }
};
