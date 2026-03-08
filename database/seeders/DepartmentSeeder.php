<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Software Development'],
            ['name' => 'Backend Development'],
            ['name' => 'Frontend Development'],
            ['name' => 'DevOps'],
            ['name' => 'Product Strategy'],
            ['name' => 'Quality Assurance'],
            ['name' => 'System Administration'],
            ['name' => 'Network Administration'],
            ['name' => 'Client Relations'],
            ['name' => 'Digital Marketing'],
            ['name' => 'Talent Acquisition'],
            ['name' => 'Financial Analysis'],
            ['name' => 'Cybersecurity'],
            ['name' => 'Technical Support'],
        ];

        foreach ($departments as $department) {
            Department::query()->firstOrCreate(['name' => $department['name']], ['name' => $department['name']]);
        }
    }
}
