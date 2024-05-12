<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VerificationType extends Model
{
    use SoftDeletes;
    use HasFactory;

    public const ID = 'id';

    public const TYPE = 'type';

    public const DESCRIPTION = 'description';

    public const UPDATED_AT = 'updated_at';

    public const CREATED_AT = 'created_at';

    public const FORGET_PASSWORD = 'forgot-password';

    public const ACTIVATION = 'user-activation';

    protected $perPage = 20;

    protected $fillable = [
        self::TYPE,
        self::DESCRIPTION,
    ];

    protected function casts(): array
    {
        return [
            self::UPDATED_AT => 'datetime',
            self::CREATED_AT => 'datetime',
            self::ID => 'int',
        ];
    }

    public function verification_codes(): HasMany
    {
        return $this->hasMany(VerificationCode::class, VerificationCode::TYPE_ID);
    }
}
