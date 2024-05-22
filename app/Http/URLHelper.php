<?php

namespace App\Http;

use App\Models\Tenant;
use App\Models\User;
use App\Models\VerificationCode;
use App\Models\VerificationType;

class URLHelper
{

    public static function getNewTenantActivationLink(int $userId): string
    {
        $verificationType = VerificationType::ACTIVATION;
        $linkExpireOn = VerificationCode::userActivationCodeExpiration();
        $activationCode = Helper::createNewVerificationCode($verificationType, $linkExpireOn, $userId, User::MORPH_CLASS);

        return config('constants.frontend_base_url') . "/auth/accountActivate/{$activationCode}";
    }

}
