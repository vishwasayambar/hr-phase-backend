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
        Schema::table('permissions',function (Blueprint $table) {
            $table->after('name',function (Blueprint $table){
               $table->string('display_name');
               $table->string('module_name');
               $table->foreignId('updated_by')->nullable()
                   ->constrained('users')
                   ->onUpdate('cascade')
                   ->onDelete('cascade');
               $table->softDeletes();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions',function(Blueprint $table){
            $table->dropForeign('permissions_updated_by_foreign');
            $table->dropColumn(['display_name', 'module_name', 'updated_by']);
        });
    }
};
