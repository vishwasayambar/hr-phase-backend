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
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('type_id')->after('tenant_id')
                ->constrained('user_types')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('display_name')->after('name')->nullable();
            $table->string('mobile_number')->nullable()->after('email');
            $table->string('phone_number')->nullable()->after('mobile_number');
            $table->string('gst_number')->nullable()->after('phone_number');
            $table->string('date_of_birth')->nullable()->after('gst_number');
            $table->string('gender')->nullable()->after('date_of_birth');
            $table->string('last_login')->nullable()->after('gender');
            $table->boolean('is_active')->default(true)->after('last_login');

            $table->foreignId('referred_by_id')->nullable()->after('is_active')->constrained('users')->nullOnDelete();
            $table->string('firebase_id')->nullable()->after('referred_by_id');

            $table->string('unique_identification_number')->nullable()->after('firebase_id');
            $table->string('emergency_contact_name')->nullable()->after('unique_identification_number');
            $table->string('emergency_contact_number')->nullable()->after('emergency_contact_name');
            $table->string('father_name')->nullable()->after('emergency_contact_number');
            $table->string('tax_number')->nullable()->after('father_name');
            $table->integer('probation_period')->nullable()->after('tax_number');
            $table->date('date_of_joining')->nullable()->after('probation_period');
            $table->foreignId('reporting_manager_id')->nullable()->after('date_of_joining')->constrained('users')->nullOnDelete();
            $table->foreignId('department_id')->nullable()->after('reporting_manager_id')->constrained('departments')->nullOnDelete();
            $table->string('grade')->nullable()->after('department_id');
            $table->string('attendance_scheme')->nullable()->after('grade');
            $table->string('pf_number')->nullable()->after('attendance_scheme');
            $table->string('uan_number')->nullable()->after('pf_number');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropForeign(['type_id']);
            $table->dropForeign(['reporting_manager_id']);
            $table->dropForeign(['department_id']);

            $table->dropColumn([
                'tenant_id',
                'type_id',
                'reporting_manager_id',
                'department_id',
                'display_name',
                'mobile_number',
                'phone_number',
                'gst_number',
                'date_of_birth',
                'gender',
                'last_login',
                'is_active',
                'unique_identification_number',
                'emergency_contact_name',
                'emergency_contact_number',
                'father_name',
                'tax_number',
                'probation_period',
                'date_of_joining',
                'grade',
                'attendance_scheme',
                'pf_number',
                'uan_number',
            ]);
        });
    }

};
