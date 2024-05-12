<?php

namespace App\Models;

use App\Mail\TenantRegisterMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Tenant extends Model
{
    use HasFactory;

    public const ID = 'id';

    public const NAME = 'name';

    public const EMAIL = 'email';

    public const MERCHANT_ID = 'merchant_id';

    public const PLAN = 'plan';

    public const ACCOUNT_ID = 'account_id';

    public const TRIAL_ENDS_AT = 'trial_ends_at';

    public const SMS_CREDITS = 'sms_credits';

    public const WHATS_APP_NUMBER = 'whats_app_number';

    public const SUPPORT_NUMBER = 'support_number';

    public const ALTERNATE_NUMBER = 'alternate_number';

    public const SUPPORT_EMAIL = 'support_email';

    public const IS_COMPLETED_WIZARD_SETUP = 'is_completed_wizard_setup';

    public const INFO = 'info';

    public const REVIEW_LINKS = 'review_links';

    public const SETTINGS = 'settings';

    public const ASSIGNEE_ID = 'assignee_id';

    public const UPDATED_AT = 'updated_at';

    public const CREATED_AT = 'created_at';

    public const DELETED_AT = 'deleted_at';

    public const DATA = 'data';

    protected $perPage = 20;

    protected $fillable = [
        self::NAME,
        self::EMAIL,
        self::ACCOUNT_ID,
        self::SMS_CREDITS,
        self::MERCHANT_ID,
        self::TRIAL_ENDS_AT,
        self::DATA,
        self::REVIEW_LINKS,
        self::PLAN,
        self::ASSIGNEE_ID,
        self::INFO,
        self::IS_COMPLETED_WIZARD_SETUP,
        self::SUPPORT_EMAIL,
        self::ALTERNATE_NUMBER,
        self::SUPPORT_NUMBER,
        self::WHATS_APP_NUMBER,
    ];

    protected function casts(): array
    {
        return [
            self::CREATED_AT => 'datetime',
            self::UPDATED_AT => 'datetime',
            self::DELETED_AT => 'datetime',
            self::ID => 'int',
            self::ACCOUNT_ID => 'int',
            self::SMS_CREDITS => 'int',
            self::DATA => 'json',
            self::INFO => 'array',
            self::REVIEW_LINKS => 'array',
            self::SETTINGS => 'json',
            self::TRIAL_ENDS_AT => 'datetime',
        ];
    }


    protected static function booted(): void
    {
        static::created(function ($tenant){
            $user = User::query()->create([
                'name' => $tenant->name,
                'tenant_id' => $tenant->id,
                'type_id' => 1,
                'email' => $tenant->email,
                'password' => "magic123",
            ]);
            logger("Hello". print_r($user,true));
            Mail::to($user)->send(new TenantRegisterMail($user));

        });
    }
}
