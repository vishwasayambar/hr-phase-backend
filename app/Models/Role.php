<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    use CascadeSoftDeletes, SoftDeletes;
    use HasFactory;

    public const ID = 'id';

    public const NAME = 'name';

    public const DISPLAY_NAME = 'display_name';

    public const GUARD_NAME = 'guard_name';

    public const CREATED_AT = 'created_at';

    public const UPDATED_AT = 'updated_at';

    public const ADMIN = 'admin';
    public const HUMAN_RESOURCE = 'human_resource';
    public const DEVELOPER = 'developer';


    protected $perPage = 20;

    protected $fillable = [
        self::NAME,
        self::DISPLAY_NAME,
        self::GUARD_NAME,
    ];

    protected function casts(): array
    {
        return [
            self::CREATED_AT => 'datetime',
            self::UPDATED_AT => 'datetime',
            self::ID => 'int',
        ];
    }

    public function name(): Attribute
    {
        return Attribute::make(set: fn(string $value) => Str::snake($value));
    }

    public function model_has_roles(): HasMany
    {
        return $this->hasMany(ModelHasRole::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }

    protected static function booted(): void
    {
        static::created(function ($tenant) {
            Cache::forget('employee_roles');
        });
    }
}
