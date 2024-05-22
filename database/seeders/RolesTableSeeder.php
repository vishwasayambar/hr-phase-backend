<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        Role::query()->insert([
            [
                'id' => 1,
                'name' => 'admin',
                'display_name' => 'Admin',
                'guard_name' => 'api',
            ],
            [
                'id' => 2,
                'name' => 'developer',
                'display_name' => 'Developer',
                'guard_name' => 'api',
            ],
            [
                'id' => 3,
                'name' => 'tester',
                'display_name' => 'Tester',
                'guard_name' => 'api',
            ],
        ]);
    }
}
