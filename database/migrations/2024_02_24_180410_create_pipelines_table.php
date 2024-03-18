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
        Schema::create('pipelines', function (Blueprint $table) {
            $table->id();
            $table->enum('stage', ['Contact', 'Lead', 'Opportunity', 'Cold', 'Reject', 'Closed'])->default('Contact');
            $table->string('name');
            $table->string('company');
            $table->integer('tatDays')->default(0);
            $table->string('department')->nullable();
            $table->enum('lead_type', ['individual', 'corporate'])->default('individual');
            $table->enum('product', ['vendor financing', 'dealer financing'])->default('vendor financing');
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('point_of_contact')->nullable();
            $table->string('contact_role')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('bank_id')->default('1');
            $table->string('region')->nullable();
            $table->string('country')->nullable();
            $table->string('industry')->nullable();
            $table->string('location')->nullable();
            $table->string('campaign')->nullable();
            $table->string('pipeline_id')->nullable();
            $table->string('contact_send_email_id')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->default('other');
            $table->enum('status', ['hot', 'warm', 'cold'])->default('hot');
            $table->enum('priority', ['high', 'medium', 'low'])->default('high');
            $table->enum('source', ['Email', 'Marketing', 'Outdoor', 'LinkedIn', 'Messages', 'Google', 'Adverts'])->default('Google');
            $table->string('owner');
            $table->string('branch')->default('Nairobi');
            $table->string('associated_user')->default('Nairobi');
            $table->enum('interaction_type', ['phone', 'email', 'sms', 'physical'])->default('email');
            $table->string('very_next_step')->default('call');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pipelines');
    }
};
