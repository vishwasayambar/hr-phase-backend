<?php

namespace Database\Seeders;

use App\Models\VerificationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VerificationTypeSeeder extends Seeder
{
    public function run(): void
    {
        $verificationTypes = [
            [
                'type' => 'user-activation',
                'description' => 'Activate the user upon clicking the activation link sent via email upon registration.'
            ],
            [
                'type' => 'forgot-password',
                'description' => 'Reset the password by sending a unique link containing a unique code/token/guid for authentication.'
            ]
        ];

        foreach ($verificationTypes as $userType) {
            VerificationType::query()->firstOrCreate(['type' => $userType['type']], $userType);
        }
    }
}
