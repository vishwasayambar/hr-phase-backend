<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\SetTenantId;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use  HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    use SetTenantId;

    public const ID                = 'id';
    public const TENANT_ID         = 'tenant_id';
    public const TYPE_ID           = 'type_id';
    public const NAME              = 'name';
    public const DISPLAY_NAME      = 'display_name';
    public const EMAIL             = 'email';
    public const MOBILE_NUMBER     = 'mobile_number';
    public const PHONE_NUMBER      = 'phone_number';
    public const GST_NUMBER        = 'gst_number';
    public const DATE_OF_BIRTH     = 'date_of_birth';
    public const GENDER            = 'gender';
    public const LAST_LOGIN        = 'last_login';
    public const IS_ACTIVE         = 'is_active';
    public const PASSWORD          = 'password';
    public const REMEMBER_TOKEN    = 'remember_token';
    public const EMAIL_VERIFIED_AT = 'email_verified_at';
    public const REFERRED_BY_ID    = 'referred_by_id';
    public const FIREBASE_UID      = 'firebase_id';
    public const MORPH_CLASS       = 'user';

    public $table = 'users';

    protected $fillable = [
        self::FIREBASE_UID,
        self::NAME,
        self::TYPE_ID,
        self::TENANT_ID,
        self::DISPLAY_NAME,
        self::EMAIL,
        self::MOBILE_NUMBER,
        self::PHONE_NUMBER,
        self::GST_NUMBER,
        self::REFERRED_BY_ID,
        self::GENDER,
        self::DATE_OF_BIRTH,
        self::LAST_LOGIN,
        self::IS_ACTIVE,
        self::PASSWORD,
        self::EMAIL_VERIFIED_AT,
        self::REMEMBER_TOKEN,
    ];

    protected $hidden = [
        self::PASSWORD,
        self::REMEMBER_TOKEN,
    ];

    /**
     * Get the attributes that should be cast.
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            self::ID => 'int',
            self::DATE_OF_BIRTH => 'datetime',
            self::LAST_LOGIN => 'datetime',
            self::EMAIL_VERIFIED_AT => 'datetime',
            self::CREATED_AT => 'datetime',
            self::UPDATED_AT => 'datetime',
            self::IS_ACTIVE => 'boolean',
            self::REFERRED_BY_ID => 'int',
            self::TYPE_ID => 'int',
        ];
    }

    public function name(): Attribute
    {
        return Attribute::make(set: fn(string $value) => ucwords($value),);
    }

    public function email(): Attribute
    {
        return Attribute::make(set: fn(string $value) => strtolower($value),);
    }

    public function password(): Attribute
    {
        return Attribute::make(set: fn(string $value) => bcrypt($value),);
    }

    public function address(): MorphMany
    {
        return $this->morphMany(Addressable::class, 'addressable');
    }

    public function bank(): MorphMany
    {
        return $this->morphMany(Bank::class, 'bankable');
    }

    protected static function boot(): void
    {
        parent::boot();
        self::bootSetsTenantId();
    }

}
