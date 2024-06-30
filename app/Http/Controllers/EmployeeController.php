<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Bank;
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
            $validatedData = $request->validated();
            $user = User::query()->create($validatedData);
            if ($request->has('address') && array_filter($request->input('address'))) {
                $user->address()->createMany($validatedData['address']);
            }
            if ($request->has('bank') && array_filter($request->input('bank'))) {
                $user->bank()->createMany($validatedData['bank']);
            }
            return response($user->loadMissing('address', 'bank'));
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
