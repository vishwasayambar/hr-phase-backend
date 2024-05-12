<?php

use Database\Seeders\VerificationTypeSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('verification_types', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50)->unique();
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Artisan::call('db:seed', ['--class' => VerificationTypeSeeder::class]);
    }

    public function down(): void
    {
        Schema::dropIfExists('verification_types');
    }
};
