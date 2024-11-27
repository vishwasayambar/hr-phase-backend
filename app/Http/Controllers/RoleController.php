<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Models\Role;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class RoleController
{

    public function store(StoreRoleRequest $request): \Spatie\Permission\Contracts\Role|\Spatie\Permission\Models\Role
    {
        return Role::create($request->validated());
    }

    public function getEmployeeRoles(): Response
    {
        return response(Cache::rememberForever('employee_roles', fn () => Role::query()->get()));
    }

    public function getCustomerRoles(): Response
    {
        return response(Cache::rememberForever('customer_roles', fn () => Role::whereIsEmployee(false)->get()));
    }
}
