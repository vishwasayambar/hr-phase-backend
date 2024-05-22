<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelHasPermission extends Model
{
    use CascadeSoftDeletes, SoftDeletes;

    public const PERMISSION_ID = 'permission_id';

    public const MODEL_TYPE = 'model_type';

    public const MODEL_ID = 'model_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $perPage = 20;

    protected $casts = [
        self::PERMISSION_ID => 'int',
        self::MODEL_ID => 'int',
    ];

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }
}
