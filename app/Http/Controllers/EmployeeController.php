<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{

    public function index(Request $request): LengthAwarePaginator
    {
        $currentPage = $request->input('page');
        Paginator::currentPageResolver(fn() => $currentPage);
        return User::query()->with('roles')->filter($request->all())->sortByField($request->input('order_by'), $request->input('order_by_direction'))
            ->paginate($request->input('per_page', 20));
    }

    public function store(StoreEmployeeRequest $request)
    {
        return DB::transaction(function () use ($request) {
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

    public function show(User $employee)
    {
        //
    }

    public function update(UpdateEmployeeRequest $request, User $employee)
    {
        //
    }

    public function destroy(User $employee)
    {
        //
    }
}
