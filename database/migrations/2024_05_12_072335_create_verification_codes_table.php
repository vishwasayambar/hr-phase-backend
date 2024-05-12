<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verification_codes', function (Blueprint $table) {
            $table->id();
            $table->morphs('verifiable');
            $table->foreignId('type_id')->constrained('verification_types')->onUpdate('cascade')->onDelete('cascade');
            $table->string('code');
            $table->dateTime('expire_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verification_codes');
    }
};
