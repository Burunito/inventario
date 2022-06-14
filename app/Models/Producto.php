<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = "productos";

    protected $fillable = [
        'sku',
        'nombre',
        'descripcion',
        'precio',
        'cantidad',
        'estado'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function categorias()
    {
        return $this->hasMany(CategoriaProducto::class);
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }
}
