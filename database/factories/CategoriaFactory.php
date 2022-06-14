<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Provider\Base;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{
    protected static $categorias = [
        'Bebidas',
        'Comida',
        'HIgiene',
        'Enlatados',
        'Lácteos',
        'Energizantes',
        'Medicamentos',
        'Jarabes',
        'Cereales',
        'Jugos',
        'Papeleria',
        'Oficina',
        'Herramientas',
        'Baño',
        'Utencilios',
        'Helados',
        'Electrónica',
        'Verduras',
        'Frutas',
        'Farmacia'
    ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => Base::randomElement(static::$categorias)
        ];
    }
}
