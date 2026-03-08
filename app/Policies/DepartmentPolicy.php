<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\Permission;
use App\Models\User;

class DepartmentPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function index(User $user): bool
    {
        return $user->hasAccessTo(Permission::DEPARTMENT_LIST);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAccessTo(Permission::DEPARTMENT_WRITE);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Department $department): bool
    {
        return $user->hasAccessTo(Permission::DEPARTMENT_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Department $department): bool
    {
        return $user->hasAccessTo(Permission::DEPARTMENT_DELETE);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Department $department): bool
    {
        return $user->hasAccessTo(Permission::ALL_MODULE_RESTORE);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Department $department): bool
    {
        return $user->hasAccessTo(Permission::ALL_MODULE_FORCE_DELETE);
    }
}
