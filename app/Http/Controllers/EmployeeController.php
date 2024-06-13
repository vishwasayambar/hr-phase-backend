<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{

    public function index()
    {
        //
    }

    public function store(StoreEmployeeRequest $request)
    {
        return DB::transaction(function () use ($request){
            return User::query()->create($request->validated());
        });
    }

    public function show(Employee $employee)
    {
        //
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        //
    }

    public function destroy(Employee $employee)
    {
        //
    }
}
