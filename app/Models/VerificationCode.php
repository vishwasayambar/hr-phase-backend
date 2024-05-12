<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VerificationCode extends Model
{
    use SoftDeletes;
    use HasFactory;

    public const ID = 'id';

    public const VERIFIABLE_ID = 'verifiable_id';

    public const VERIFIABLE_TYPE = 'verifiable_type';

    public const TYPE_ID = 'type_id';

    public const CODE = 'code';

    public const EXPIRE_AT = 'expire_at';

    public const UPDATED_AT = 'updated_at';

    public const CREATED_AT = 'created_at';

    protected $perPage = 20;

    protected $fillable = [
        self::VERIFIABLE_ID,
        self::VERIFIABLE_TYPE,
        self::TYPE_ID,
        self::CODE,
        self::EXPIRE_AT,
    ];

    protected function casts(): array
    {
        return [
            self::EXPIRE_AT => 'datetime',
            self::UPDATED_AT => 'datetime',
            self::CREATED_AT => 'datetime',
            self::ID => 'int',
            self::VERIFIABLE_ID => 'int',
            self::VERIFIABLE_TYPE => 'string',
            self::TYPE_ID => 'int',
        ];
    }

    public static function forgotPasswordCodeExpiration(): string
    {
        return date('Y-m-d H:i:s', strtotime(now()->addDays(3)));
    }

    public static function userActivationCodeExpiration(): string
    {
        return date('Y-m-d H:i:s', strtotime(now()->addMonth()));
    }

    public static function passwordResetUrl($verificationCode): string
    {
        return config('app.url') . '/auth/responsePasswordReset/' . $verificationCode;
    }

    public static function userActivationUrl($verificationCode): string
    {
        return config('app.url') . '/auth/accountActivate/' . $verificationCode;
    }

    public function verification_type(): BelongsTo
    {
        return $this->belongsTo(VerificationType::class, self::TYPE_ID);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->select(['id', 'name', 'display_name', 'email', 'mobile_number', 'phone_number', 'gst_number', 'type_id']);
    }
}
