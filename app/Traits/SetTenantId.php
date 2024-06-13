<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait SetTenantId
{
    protected static function bootSetsTenantId(): void
    {
        static::creating(function ($model) {
            if (Auth::check() && empty($model->tenant_id)) {
                $model->tenant_id = Auth::user()->tenant_id;
            }
        });
    }
}
