<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategoriaProducto;
use App\Models\Calificacion;
use App\Models\Producto;
use App\Models\Categoria;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Categoria::factory(4)->create();
        Producto::factory(200)->create()->each(function($producto) 
        {
            $producto->calificaciones()->saveMany(Calificacion::factory(random_int( 1, 8))->make());
            $producto->categorias()->saveMany(CategoriaProducto::factory(random_int( 1, 3))->make());
        });
    }
}
