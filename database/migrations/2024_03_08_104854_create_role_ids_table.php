<?php

use App\Models\AccessRightGroup;
use App\Models\PermissionData;
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
        Schema::create('role_ids', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PermissionData::class);
            $table->foreignIdFor(AccessRightGroup::class);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_ids');
    }
};
