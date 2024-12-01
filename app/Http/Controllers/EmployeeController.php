<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
            $role = Role::query()->findOrFail($request->input('role_id'));
            $user->assignRole($role->name);
            return response($user->loadMissing('address', 'bank'));
        });
    }

    public function show(Request $request, int $id): Response
    {
        return response(User::query()->findOrFail($id)->loadMissing('address', 'bank'));
    }

    public function update(UpdateEmployeeRequest $request, User $employee): Response
    {
        return DB::transaction(function () use ($request, $employee) {
            $employee->update($request->validated());
            if ($request->has('address')) {
                $this->updateRelatedData(
                    $employee,
                    'address',
                    $request->validated()['address'] ?? []
                );
            }
            if ($request->has('bank')) {
                $this->updateRelatedData(
                    $employee,
                    'bank',
                    $request->validated()['bank'] ?? []
                );
            }
            return response($employee->loadMissing('address', 'bank'));
        });
    }

    public function destroy(User $employee): Response
    {
        try {
            return response($employee->delete());
        } catch (Exception $e) {
            return response('ERROR IN DELETING Employee AND ERROR MESSAGE IS ', $e->getMessage());
        }
    }

    /**
     * Update related data for a given employee.
     *
     * @param User|null $employee
     * @param string $relation
     * @param array $data
     * @return void
     */
    private function updateRelatedData(User|null $employee, string $relation, array $data): void
    {
        if (!empty(array_filter($data))) {
            foreach ($data as &$item) {
                $item["{$relation}able_id"] = $employee->id; // Dynamically set the relation ID
            }
            unset($item);

            $employee->$relation()->delete(); // Clear existing data
            $employee->$relation()->createMany($data); // Insert new data
        }
    }
}
