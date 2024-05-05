<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('trial_ends_at')->nullable();
            $table->bigInteger('account_id')->unique()->unsigned();
            $table->bigInteger('sms_credits')->default(0)->unsigned();
            $table->string('whats_app_number')->nullable();
            $table->string('support_number')->nullable();
            $table->string('support_email')->nullable();
            $table->boolean('is_completed_wizard_setup')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
