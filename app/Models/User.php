<?php

namespace App\Models;

use App\Traits\HasSorting;
use App\Traits\SetTenantId;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use  HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    use HasSorting;
    use SetTenantId;

    public const ID = 'id';
    public const TENANT_ID = 'tenant_id';
    public const TYPE_ID = 'type_id';
    public const NAME = 'name';
    public const DISPLAY_NAME = 'display_name';
    public const EMAIL = 'email';
    public const MOBILE_NUMBER = 'mobile_number';
    public const PHONE_NUMBER = 'phone_number';
    public const GST_NUMBER = 'gst_number';
    public const DATE_OF_BIRTH = 'date_of_birth';
    public const GENDER = 'gender';
    public const LAST_LOGIN = 'last_login';
    public const IS_ACTIVE = 'is_active';
    public const PASSWORD = 'password';
    public const REMEMBER_TOKEN = 'remember_token';
    public const EMAIL_VERIFIED_AT = 'email_verified_at';
    public const REFERRED_BY_ID = 'referred_by_id';
    public const FIREBASE_UID = 'firebase_id';
    public const EMERGENCY_CONTACT_NAME = 'emergency_contact_name';
    public const EMERGENCY_CONTACT_NUMBER = 'emergency_contact_number';
    public const FATHER_NAME = 'father_name';
    public const UNIQUE_IDENTIFICATION_NUMBER = 'unique_identification_number';
    public const TAX_NUMBER = 'tax_number';
    public const PROBATION_PERIOD = 'probation_period';
    public const DATE_OF_JOINING = 'date_of_joining';
    public const REPORTING_MANAGER_ID = 'reporting_manager_id';
    public const DEPARTMENT_ID = 'department_id';
    public const GRADE = 'grade';
    public const ATTENDANCE_SCHEME = 'attendance_scheme';
    public const PF_NUMBER = 'pf_number';
    public const UAN_NUMBER = 'uan_number';

    public const MORPH_CLASS = 'user';

    public array $sortableColumns = [self::DATE_OF_BIRTH];

    public $table = 'users';

    protected string $guard_name = 'api';

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
        self::EMERGENCY_CONTACT_NAME,
        self::EMERGENCY_CONTACT_NUMBER,
        self::FATHER_NAME,
        self::UNIQUE_IDENTIFICATION_NUMBER,
        self::TAX_NUMBER,
        self::PROBATION_PERIOD,
        self::DATE_OF_JOINING,
        self::REPORTING_MANAGER_ID,
        self::DEPARTMENT_ID,
        self::GRADE,
        self::ATTENDANCE_SCHEME,
        self::PF_NUMBER,
        self::UAN_NUMBER,
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
            self::EMERGENCY_CONTACT_NAME => 'string',
            self::EMERGENCY_CONTACT_NUMBER => 'string',
            self::FATHER_NAME => 'string',
            self::UNIQUE_IDENTIFICATION_NUMBER => 'string',
            self::TAX_NUMBER => 'string',
            self::PROBATION_PERIOD => 'int',
            self::DATE_OF_JOINING => 'date',
            self::REPORTING_MANAGER_ID => 'int',
            self::DEPARTMENT_ID => 'int',
            self::GRADE => 'string',
            self::ATTENDANCE_SCHEME => 'string',
            self::PF_NUMBER => 'string',
            self::UAN_NUMBER => 'int',

        ];
    }

    public function name(): Attribute
    {
        return Attribute::make(set: fn(string $value) => ucwords($value));
    }

    public function email(): Attribute
    {
        return Attribute::make(set: fn(string $value) => strtolower($value));
    }

    public function password(): Attribute
    {
        return Attribute::make(set: fn(string $value) => bcrypt($value));
    }

    public function address(): MorphMany
    {
        return $this->morphMany(Addressable::class, 'addressable');
    }

    public function bank(): MorphMany
    {
        return $this->morphMany(Bank::class, 'bankable');
    }

    /**
     * Get the department associated with the user.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    protected static function boot(): void
    {
        parent::boot();
        self::bootSetsTenantId();
    }

    public function scopeFilter($query, $filter): Builder
    {
        $query->search(Arr::get($filter, 'search'));
        return $query;
    }

    public function scopeSearch($query, $search): Builder
    {
        return $query->when($search, function ($query) use ($search) {
            $query->whereAny([
                self::NAME,
                self::DISPLAY_NAME,
                self::EMAIL,
                self::MOBILE_NUMBER,
                self::PHONE_NUMBER,
            ], 'LIKE', "%{$search}%");
        });
    }

    /**
     * Check if the user has a specific permission, either directly or through their roles.
     *
     * Steps:
     * 1. First, check if the user has the permission directly assigned (via model_has_permissions).
     *    - If yes, return true.
     * 2. If the user doesn't have the permission directly, check their roles.
     *    - Only check roles if the user has no direct permissions.
     *    - If any role grants the permission, return true.
     * 3. If neither the user nor their roles have the permission, return false.
     *
     * @param string $permissionName The name of the permission to check.
     * @return bool True if the user has the permission, false otherwise.
     */
    public function hasAccessTo(string $permissionName): bool
    {
        // Step 1: Check if the user has the permission directly in model_has_permissions
        if ($this->permissions->contains('name', $permissionName)) {
            return true;  // User has the permission directly
        }

        // Step 2: If the user doesn't have the permission directly, check their roles
        // This step only happens if no direct permissions are found
        if ($this->permissions()->count() === 0) {
            // If no direct permissions, check if any of the user's roles give this permission
            return $this->roles->contains(fn($role) => $role->hasPermissionTo($permissionName));
        }

        // If no permission found directly or through roles, return false
        return false;
    }
}
