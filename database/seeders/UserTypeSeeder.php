<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    public function run(): void
    {
        $userTypes = [
            ['id' => 1, 'name' => 'human_resource'],
            ['id' => 2, 'name' => 'employee'],
        ];
        foreach ($userTypes as $userType) {
            UserType::firstOrCreate(['id' => $userType['id']], ['name' => $userType['name']]);
        }
    }
}
