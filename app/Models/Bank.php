<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use CascadeSoftDeletes, SoftDeletes;

    public const ID = 'id';

    public const BANKABLE_TYPE = 'bankable_type';

    public const BANKABLE_ID = 'bankable_id';

    public const ACCOUNT_NUMBER = 'account_number';

    public const ACCOUNT_NAME = 'account_name';

    public const IFSC_CODE = 'ifsc_code';

    public const BRANCH_NAME = 'branch_name';

    public const BANK_NAME = 'bank_name';

    public const CREATED_AT = 'created_at';

    public const UPDATED_AT = 'updated_at';

    protected $perPage = 20;

    protected $fillable = [
        self::BANKABLE_TYPE,
        self::BANKABLE_ID,
        self::ACCOUNT_NUMBER,
        self::ACCOUNT_NAME,
        self::IFSC_CODE,
        self::BRANCH_NAME,
        self::BANK_NAME,
    ];

    protected function casts(): array
    {
        return [
            self::CREATED_AT => 'datetime',
            self::UPDATED_AT => 'datetime',
            self::ID => 'int',
            self::BANKABLE_ID => 'int',
        ];
    }

    public function bankable(): MorphTo {
        return $this->morphTo();
    }

}
