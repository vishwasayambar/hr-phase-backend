<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UserTypeSeeder::class);
        $this->call(VerificationTypeSeeder::class);
        $this->call(PermissionSeeder::class);
    }
}
