<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $empleados = \App\Models\Employee::all();
        $roles = \App\Models\Role::all();

        foreach ($empleados as $empleado) {
            $empleado->roles()->attach($roles->random(rand(1, 2)));
        }
    }
}
