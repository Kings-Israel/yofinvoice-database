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
        Schema::create('interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Pipeline::class);
            $table->string('stage');
            $table->string('touchPoint')->default('ETC');
            $table->text('remarks')->nullable();
            $table->string('veryNextStep')->nullable();
            $table->timestamps();
        });
    }

    /**
     *  id: 0,
    stage: 'Contact',
    name: '',
    touchPoint: 'Physical Meeting',
    remarks: '',
    veryNextStep: '',
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interactions');
    }
};
