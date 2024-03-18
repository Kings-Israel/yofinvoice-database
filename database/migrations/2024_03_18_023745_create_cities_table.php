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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('city_ascii');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('country');
            $table->string('iso2');
            $table->string('iso3');
            $table->string('admin_name')->nullable();
            $table->string('capital')->nullable();
            $table->string('population')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
