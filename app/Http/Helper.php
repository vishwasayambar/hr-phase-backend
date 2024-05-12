<?php

namespace App\Http;

use App\Models\User;
use App\Models\VerificationCode;
use App\Models\VerificationType;
use Ramsey\Uuid\Uuid as UniqueIdGenerator;

class Helper
{
    public static function createNewVerificationCode(string $verificationType, $linkExpireOn, int $verifiableId, string $verifiableType, bool $isNumericOnly = false): string
    {
        info("In verificationType:$verificationType, linkExpireOn:$linkExpireOn, for verifiableId:$verifiableId");
        $verificationType = VerificationType::query()->whereType($verificationType)->firstOrFail();
        $code = self::getVerificationCode($isNumericOnly);
        VerificationCode::query()->where('verifiable_id', $verifiableId)
            ->where('verifiable_type', $verifiableType)
            ->where('type_id', $verificationType->id)
            ->delete();
        $verificationCode = VerificationCode::query()->create([
            'verifiable_id' => $verifiableId,
            'verifiable_type' => $verifiableType,
            'type_id' => $verificationType->id,
            'expire_at' => $linkExpireOn,
            'code' => $code,
        ]);
        info("Verification code created for verifiable_id:$verifiableId, for verifiableType :verifiableType and expireOn:linkExpireOn, code:$code");

        return $verificationCode->code;
    }

    public static function getVerificationCode(bool $isNumericOnly): int|string
    {
        if ($isNumericOnly) {
            return self::randomNumber(6);
        }

        return UniqueIdGenerator::uuid4()->toString();
    }

    public static function randomNumber($length): int
    {
        $result = '';
        // Prevent first letter zero as casting to int removes leading zero
        $result .= mt_rand(1, 9);
        for ($i = 0; $i < $length - 1; $i++) {
            $result .= mt_rand(0, 9);
        }

        return (int) $result;
    }


}
