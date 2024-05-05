<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('tenant_id')->after('id')
                ->constrained('tenants')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('type_id')->after('tenant_id')
                ->constrained('user_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('display_name')->after('name')->nullable();
            $table->string('mobile_number')->nullable()->after('email');
            $table->string('phone_number')->nullable()->after('mobile_number');
            $table->string('gst_number')->nullable()->after('phone_number');
            $table->string('date_of_birth')->nullable()->after('gst_number');
            $table->string('gender')->nullable()->after('date_of_birth');
            $table->string('last_login')->nullable()->after('gender');
            $table->boolean('is_active')->default(true)->after('gender');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropForeign(['type_id']);
            $table->dropColumn('tenant_id');
            $table->dropColumn('type_id');
            $table->dropColumn('display_name');
            $table->dropColumn('mobile_number');
            $table->dropColumn('phone_number');
            $table->dropColumn('gst_number');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('gender');
            $table->dropColumn('last_login');
            $table->dropColumn('is_active');
        });
    }

};
