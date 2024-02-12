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
        Schema::create('program_bank_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->references('id')->on('programs')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name_as_per_bank')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('account_type')->nullable();
            $table->enum('status', ['active', 'inactive'])->nullable()->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_bank_details');
    }
};
