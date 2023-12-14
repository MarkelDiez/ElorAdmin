<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::truncate();

        $departmentModel = new Department();

        $departmentModel->create([
            'name' => 'Informática'
        ]);

        $departmentModel->create([
            'name' => 'FOL'
        ]);

        $departmentModel->create([
            'name' => 'Química'
        ]);

        $departmentModel->create([
            'name' => 'Marketing'
        ]);
    }
}
