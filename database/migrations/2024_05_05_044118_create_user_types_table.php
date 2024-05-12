<?php

use Database\Seeders\UserTypeSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Artisan::call('db:seed', ['--class' => UserTypeSeeder::class]);

    }

    public function down(): void
    {
        Schema::dropIfExists('user_types');
    }
};
