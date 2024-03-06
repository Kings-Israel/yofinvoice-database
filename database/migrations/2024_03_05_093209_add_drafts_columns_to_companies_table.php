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
        Schema::table('companies', function (Blueprint $table) {
            $table->boolean('is_current')->default(false);
            $table->boolean('is_published')->default(false);
            $table->dateTime('published_at')->nullable();
            $table->uuid('uuid')->nullable();
            $table->string('publisher_type')->nullable();
            $table->string('publisher_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('is_current');
            $table->dropColumn('is_published');
            $table->dropColumn('published_at');
            $table->dropColumn('uuid');
            $table->dropColumn('publisher_type');
            $table->dropColumn('publisher_id');
        });
    }
};
