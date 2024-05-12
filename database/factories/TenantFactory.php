<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenant>
 */
class TenantFactory extends Factory
{

    protected $model = Tenant::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company,
            'email' => fake()->unique()->safeEmail,
            'trial_ends_at' => fake()->optional()->dateTimeThisMonth(),
            'account_id' => fake()->unique()->randomNumber(),
            'sms_credits' => fake()->numberBetween(0, 100),
            'whats_app_number' => fake()->optional()->phoneNumber,
            'support_number' => fake()->optional()->phoneNumber,
            'support_email' => fake()->optional()->safeEmail,
            'is_completed_wizard_setup' => fake()->boolean(50),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
