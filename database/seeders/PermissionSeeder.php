<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    // Remove assigned only permissions from admin role as admin needs to show everything by default
    private static function getAdminPermissions(): array
    {
        $permissions = array_column(config('seed.permissions'), 'name');
        $permissionsToRemove = [
            'task.show_only_assigned',
        ];
        return array_values(array_diff($permissions, $permissionsToRemove));
    }

    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Permission::query()->insert(config('seed.permissions'));

        $hrPermissions = [
            Permission::EMPLOYEE_LIST,
            Permission::EMPLOYEE_WRITE,
            Permission::EMPLOYEE_EDIT,
            Permission::TASK_LIST,
            Permission::TASK_WRITE,
            Permission::TASK_EDIT,
            Permission::TASK_SHOW_ONLY_ASSIGNED,
            Permission::EXPENSES_LIST,
            Permission::EXPENSES_WRITE,
            Permission::EXPENSES_EDIT,
            Permission::EXPENSES_DELETE,
            Permission::EXPENSE_CATEGORY_LIST,
            Permission::EXPENSE_CATEGORY_WRITE,
            Permission::QUICK_REPLY_LIST,
            Permission::QUICK_REPLY_WRITE,
            Permission::QUICK_REPLY_EDIT,
        ];
        $employeeCommonPermissions = [
            Permission::TASK_LIST,
            Permission::TASK_WRITE,
            Permission::TASK_EDIT,
        ];

        $permissionsByRole = [
            Role::ADMIN => self::getAdminPermissions(),
            Role::HUMAN_RESOURCE => $hrPermissions,
            Role::DEVELOPER => $employeeCommonPermissions,
        ];

        $insertPermissions = fn ($role) => collect($permissionsByRole[$role])
            ->map(fn ($name) => DB::table('permissions')->whereName($name)->first()->id)
            ->toArray();
        $permissionIdsByRole = [
            Role::ADMIN => $insertPermissions(Role::ADMIN),
            Role::DEVELOPER => $insertPermissions(Role::DEVELOPER),
            Role::HUMAN_RESOURCE => $insertPermissions(Role::HUMAN_RESOURCE),
        ];
        foreach ($permissionIdsByRole as $role => $permissionIds) {
            $role = Role::whereName($role)->first();
            $role->syncPermissions($permissionIds);
        }
        DB::table('personal_access_tokens')->delete();
        $this->command->info('Permission configuration completed successfully!');

    }
}
