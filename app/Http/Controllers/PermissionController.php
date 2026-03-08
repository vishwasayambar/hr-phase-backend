<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PermissionController extends Controller
{
    public function index(): Response
    {
        $permissionArr = [];
        foreach (Permission::all()->groupBy('module_name') as $key => $value) {
            $permissionArr[] = (object) [
                'name' => $key,
                'items' => $value,
            ];
        }
        return response($permissionArr);
    }

    public function getByUserId(Request $request, int $userId): Response
    {
        $user = User::query()->findOrFail($userId);

        // Fetch permissions directly assigned to the user or inherited via roles
        $userPermissionArr = $user->getDirectPermissions();

        if ($userPermissionArr->isEmpty()) {
            $userPermissionArr = $user->getPermissionsViaRoles();
        }

        // Group permissions by module_name with formatted module names
        $groupedPermissions = $userPermissionArr->groupBy(function ($permission) {
            return ucwords(str_replace('_', ' ', $permission->module_name));
        })->toArray();

        return response($groupedPermissions);
    }

    public function getByRoleId(Request $request, int $roleId): Response
    {
        $rolePermission = Role::query()
            ->find($roleId)
            ->permissions->groupBy("module_name")
            ->toArray();
        return response($rolePermission);
    }

    public function assignPermissionsToRole(Request $request, int $roleId): Response
    {
        $user = User::with('permissions')->findOrFail($userId);
        $user->syncPermissions($request->input('permissions'));
        DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();

    public function updateUserDirectPermission(Request $request, int $userId): Response
    {
        $user = User::query()->findOrFail($userId);
        $selectedPermissionNames = collect($request->input('selectedPermission'))->pluck('name')->toArray();
        $user->syncPermissions($selectedPermissionNames);
        return response()->noContent();
    }
}
