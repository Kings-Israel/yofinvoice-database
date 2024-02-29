<?php

use App\Models\Pipeline;
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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('subject_type')->nullable();
            $table->string('stage')->nullable();
            $table->string('section');
            $table->foreignIdFor(Pipeline::class)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('description');
            $table->json('properties')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
