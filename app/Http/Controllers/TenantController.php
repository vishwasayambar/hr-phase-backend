<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTenantRequest;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TenantController extends Controller
{

    public function store(StoreTenantRequest $request): JsonResponse
    {

        $tenant = Tenant::latest()->first();
        $accountId = $tenant ? 100000 + $tenant->id + 1 : 100001;

        Log::info(print_r($request->all(), true));
        DB::transaction(function () use ($accountId, $tenant, $request){
           Tenant::query()->create([
                'name' => ucwords($request->input('company_name')),
                'email' => $request->input('email'),
                'support_email' => $request->input('email'),
                'support_number' => $request->input('mobile_number'),
                'plan' => $request->input('plan'),
                'source' => $request->input('source'),
                'timezone' => 'Asia/Kolkata',
                'account_id' => $accountId,
                'trial_ends_at' => today()->addMonth(),
                'sms_credits' => 50,
            ]);
        });


        return response()->json( Response::HTTP_OK);
    }

}
