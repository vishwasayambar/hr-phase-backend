<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalApiException;
use App\Http\Requests\AccountActivationRequest;
use App\Http\Requests\AccountActivationTokenVerificationRequest;
use App\Mail\TenantWelcomeMail;
use App\Models\Tenant;
use App\Models\User;
use App\Models\VerificationCode;
use App\Models\VerificationType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function registerUser(Request $request){
        $request->validate([
            'name' => "required|string",
            'tenant_id' => "required|integer",
            'type_id' => "required|integer",
            'email' => "required|email",
            'password' => "required|string|confirmed",
        ]);

        $user =  User::create([
            'name' => $request->name,
            'tenant_id' => $request->tenant_id,
            'type_id' => $request->type_id,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json(["user"=>$user]);

    }

    /**
     * @throws ValidationException
     */
    public function login(Request $request):Response | JsonResponse{
        $request->validate([
            'email' => "required|email",
            'password' => "required",
        ]);

        $user = User::query()->where('email', $request->email)->first();
//        if (! $user || ! Hash::check($request->password, $user->password)) {
//            throw ValidationException::withMessages([
//                'email' => ['The provided credentials are incorrect.'],
//            ]);
//        }
        if(!empty($user)){
            if(Hash::check($request->password, $user->password)){

                return $this->respondWithToken($user);

            }else{
                return response("Invalid password");
            }

        }else{
            return response("User not found");
        }
    }

    public function verifyToken(AccountActivationTokenVerificationRequest $request): Response
    {
        if (!$request->has('token')) {
            throw new ModelNotFoundException();
        }
        return response(VerificationCode::query()
                ->where('code', $request->get('token'))
                ->where('expire_at', '>=', date('Y-m-d H:i:s'))
                ->where('verifiable_type', User::MORPH_CLASS)
                ->whereHas('verification_type', function ($query) use ($request) {
                        $query->where('type', VerificationType::ACTIVATION);
                })
                ->firstOrFail());
    }

    public function accountActivate(AccountActivationRequest $request): JsonResponse
    {
        $verificationCode = VerificationCode::query()
            ->where('code', $request->get('token'))
            ->where('expire_at', '>=', date('Y-m-d H:i:s'))
            ->where('verifiable_type', User::MORPH_CLASS)
            ->whereHas('verification_type', function ($query) use ($request) {
                $query->where('type', VerificationType::ACTIVATION);
            })
            ->firstOrFail();
        $user = User::query()->findOrFail($verificationCode->verifiable_id);
        DB::transaction(function() use ($verificationCode, $request, $user) {
            $user->password = $request->get('password');
            $user->email_verified_at = now();
            $user->last_login = now();
            $user->save();

            Mail::to($user)->send(new TenantWelcomeMail($user));

            try {
                $verificationCode->delete();
            } catch (\Exception $e) {
                return response()->json([
                    "message" => $e->getMessage(),
                ]);
            }
        });
             return $this->respondWithToken($user);
    }

    protected function respondWithToken($user): JsonResponse
    {
        $tokenResult = $user->createToken('Password grant client');
        $permissions = $user->getDirectPermissions()->pluck('name');
        $tenant = Tenant::query()->whereId($user->tenant_id)->first();
        if (! count($permissions)) {
            $permissions = $user->getPermissionsViaRoles()->pluck('name');
        }

        return response()->json([
            'access_token' => $tokenResult->plainTextToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->accessToken->expires_at
            )->toDateTimeString(),
            'user' => $user,
            'permissions' => $permissions,
            'tenant' => $tenant,
        ]);
    }

}
