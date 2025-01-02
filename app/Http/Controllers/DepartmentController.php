<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentPage = $request->input('page');
        Paginator::currentPageResolver(fn() => $currentPage);
        return Department::query()->filter($request->all())->sortByField($request->input('order_by'), $request->input('order_by_direction'))
            ->paginate($request->input('per_page', 20));
    }

    /**
     * Display a trashed listing.
     */
    public function trashedListByQuery(Request $request)
    {
        $currentPage = $request->input('page');
        Paginator::currentPageResolver(fn() => $currentPage);
        return Department::onlyTrashed()
            ->filter($request->all())
            ->sortByField($request->input('order_by'), $request->input('order_by_direction'))
            ->paginate($request->input('per_page', 20));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
        ]);
        return response(Department::query()->create($request->all()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department): Response
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
        ]);
        return response($department->update($request->all()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department): Response
    {
        try {
            return response($department->delete());
        } catch (Exception $e) {
            return response('ERROR IN DELETING Department AND ERROR MESSAGE IS ', $e->getMessage());
        }
    }

    /**
     * Force delete a department permanently.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy(int $id): Response
    {
        // Find the soft-deleted department
        $department = Department::withTrashed()->findOrFail($id);
        try {
            return response($department->forceDelete());
        } catch (Exception $e) {
            return response('ERROR IN Force DELETING Department AND ERROR MESSAGE IS ', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function restore(int $id): Response
    {
        try {
            // Find the trashed department
            $department = Department::onlyTrashed()->findOrFail($id);

            return response($department->restore());

        } catch (Exception $e) {
            return response('ERROR IN Restoring Department AND ERROR MESSAGE IS ', $e->getMessage());
        }
    }

}
