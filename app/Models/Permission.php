<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    use HasFactory;

    public const ID = 'id';
    public const NAME = 'name';
    public const DISPLAY_NAME = 'display_name';
    public const MODULE_NAME = 'module_name';
    public const GUARD_NAME = 'guard_name';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public const BUSINESS_SETTING_VIEW = 'business_settings.view';
    public const BUSINESS_SETTING_WRITE = 'business_settings.write';
    public const BUSINESS_SETTING_EDIT = 'business_settings.edit';
    public const BUSINESS_SETTING_DELETE = 'business_settings.delete';

    public const EMPLOYEE_LIST = 'employee.list';
    public const EMPLOYEE_WRITE = 'employee.write';
    public const EMPLOYEE_EDIT = 'employee.edit';
    public const EMPLOYEE_DELETE = 'employee.delete';

    public const TASK_LIST = 'task.list';
    public const TASK_WRITE = 'task.write';
    public const TASK_EDIT = 'task.edit';
    public const TASK_DELETE = 'task.delete';
    public const TASK_SHOW_ONLY_ASSIGNED = 'task.show_only_assigned';

    public const EXPENSES_LIST = 'expense.list';
    public const EXPENSES_WRITE = 'expense.write';
    public const EXPENSES_EDIT = 'expense.edit';
    public const EXPENSES_DELETE = 'expense.delete';

    public const QUICK_REPLY_LIST = 'quick_reply.list';
    public const QUICK_REPLY_WRITE = 'quick_reply.write';
    public const QUICK_REPLY_EDIT = 'quick_reply.edit';
    public const QUICK_REPLY_DELETE = 'quick_reply.delete';

    public const EXPENSE_CATEGORY_WRITE = 'expense_category.write';
    public const EXPENSE_CATEGORY_LIST = 'expense_category.list';
    public const EXPENSE_CATEGORY_DELETE = 'expense_category.delete';

    protected $perPage = 20;

    protected $fillable = [
        self::NAME,
        self::DISPLAY_NAME,
        self::MODULE_NAME,
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

    public function getModuleNameAttribute($value): string
    {
        return ucwords(str_replace('_', ' ', $value));
    }

    public function model_has_permissions(): HasMany
    {
        return $this->hasMany(ModelHasPermission::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions');
    }
}
