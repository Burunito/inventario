<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'sku' => strtoupper(Str::random(10)),
            'nombre' => $this->faker->producto,
            'descripcion' => Str::random(10),
            'precio' => ((random_int( 5*10, 100*10)) / 10),
            'cantidad' => random_int( 1, 15),
            'estado' => 1
        ];
    }
}
