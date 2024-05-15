<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountActivationTokenVerificationRequest;
use App\Models\User;
use App\Models\VerificationCode;
use App\Models\VerificationType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
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

                $token = $user->createToken("User Token Assigned");

                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user,
//                    'permissions' => $permissions,
                ]);

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

}
