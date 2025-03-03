<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('areas')->insert([
            [ 'nombre' => 'Recursos Humanos' ],
            [ 'nombre' => 'Desarrollo' ],
            [ 'nombre' => 'Marketing' ],
        ]);
    }
}
