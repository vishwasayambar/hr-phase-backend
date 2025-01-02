<?php

namespace App\Models;

use App\Traits\HasSorting;
use App\Traits\SetTenantId;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class Department extends Model
{
    use SetTenantId;
    use HasSorting;
    use softDeletes;

    public const ID = 'id';
    public const NAME = 'name';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';

    protected $fillable = [
        self::NAME,
    ];

    protected function casts(): array
    {
        return [
            self::ID => 'int',
            self::NAME => 'string',
            self::CREATED_AT => 'datetime',
            self::UPDATED_AT => 'datetime',
        ];
    }

    /**
     * Get all users that belong to the department.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function scopeFilter($query, $filter): Builder
    {
        $search = Arr::get($filter, 'search');

        return $query->when($search, function ($query) use ($search) {
            $query->whereAny([
                self::NAME,
            ], 'LIKE', "%{$search}%");
        });
    }
}
