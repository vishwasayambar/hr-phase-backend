<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Addressable extends Model
{
    use CascadeSoftDeletes, SoftDeletes;

    public const ID = 'id';

    public const ADDRESSABLE_TYPE = 'addressable_type';

    public const ADDRESSABLE_ID = 'addressable_id';

    public const ADDRESS_LINE = 'address_line';

    public const CITY = 'city';

    public const STATE = 'state';

    public const ZIP_CODE = 'zip_code';

    public const CREATED_AT = 'created_at';

    public const UPDATED_AT = 'updated_at';

    protected $perPage = 20;

    protected $fillable = [
        self::ADDRESSABLE_TYPE,
        self::ADDRESSABLE_ID,
        self::ADDRESS_LINE,
        self::CITY,
        self::STATE,
        self::ZIP_CODE,
    ];

    protected function casts(): array
    {
        return [
            self::CREATED_AT => 'datetime',
            self::UPDATED_AT => 'datetime',
            self::ID => 'int',
            self::ADDRESSABLE_ID => 'int',
        ];
    }

    public function addressable(): MorphTo {
        return $this->morphTo();
    }

}
