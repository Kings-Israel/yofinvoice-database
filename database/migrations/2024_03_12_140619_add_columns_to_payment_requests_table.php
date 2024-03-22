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
        Schema::table('payment_requests', function (Blueprint $table) {
            DB::statement("ALTER TABLE payment_requests CHANGE COLUMN status status ENUM('created', 'paid', 'pending', 'failed', 'approved', 'rejected') NOT NULL DEFAULT 'created'");
            $table->string('rejected_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_requests', function (Blueprint $table) {
            DB::statement("ALTER TABLE payment_requests CHANGE COLUMN type type ENUM('created', 'paid', 'pending', 'failed') NULL DEFAULT 'created'");
            $table->dropColumn('rejected_reason');
        });
    }
};
