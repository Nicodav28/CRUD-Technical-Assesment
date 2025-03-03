<?php

namespace Database\Factories;

use App\Models\Area;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre'      => $this->faker->name(),
            'email'       => $this->faker->unique()->safeEmail(),
            'sexo'        => $this->faker->randomElement([ 'M', 'F' ]),
            'area_id'     => Area::inRandomOrder()->first()->id ?? Area::factory(),
            'boletin'     => $this->faker->boolean(),
            'descripcion' => $this->faker->sentence(10),
        ];
    }
}
