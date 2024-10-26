<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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

    public function getAllPermissions()
    {
        return Permission::query()->get();
    }

    public function getByUserId(Request $request, int $userId): Response
    {
        $userPermissionArr = User::query()->findOrFail($userId)->getDirectPermissions()->pluck('name')->toArray();
        if (! count($userPermissionArr)) {
            $userPermissionArr = User::query()->findOrFail($userId)->getPermissionsViaRoles()->pluck('name')->toArray();
        }
        $mappedPermissions = [];
        foreach (Permission::all()->groupBy('module_name') as $key => $permissions) {
            $permissions = $permissions->map(function ($perm) use ($userPermissionArr) {
                $perm->checked = in_array($perm->name, $userPermissionArr);

                return $perm;
            });
            $mappedPermissions[] = (object) [
                'name' => $key,
                'items' => $permissions,
            ];
        }

        return response($mappedPermissions);
    }
    public function getByRoleId(Request $request, int $roleId): Response
    {
        $rolePermission = Role::query()
            ->find($roleId)
            ->permissions->groupBy("module_name")
            ->toArray();

        return response($rolePermission);
    }

    public function update(Request $request, int $userId): Response
    {
        $user = User::with('permissions')->findOrFail($userId);
        $user->syncPermissions($request->input('permissions'));
        DB::table('oauth_access_tokens')->where('user_id', $user->id)->delete();

        return response()->noContent();
    }
}
