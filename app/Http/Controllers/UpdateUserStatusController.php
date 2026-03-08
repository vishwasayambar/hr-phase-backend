<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UpdateUserStatusController
{

    public function __invoke(Request $request, int $id): bool|int
    {
        Gate::authorize('create', User::class);
        return User::query()->findOrFail($id)->update(['is_active' => $request->input('status')]);
    }
}
