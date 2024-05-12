<?php

return [
    'verificationTypes' => [
        'forgotPassword' => [
            'type' => 'forgot-password',
            'expirationInDays' => 10,
        ],
        'userActivation' => [
            'type' => 'user-activation',
            'expirationInDays' => 30,
        ],
    ],
    'slack_webhook' => env('SLACK_WEBHOOK_URL'),
    'support_email' => env('SUPPORT_EMAIL'),
    'support_phone_number' => env('SUPPORT_PHONE_NUMBER'),
    'app_name' => env('APP_NAME'),
    'frontend_base_url' => env('FRONTEND_BASE_URL', env('APP_URL')),
];
