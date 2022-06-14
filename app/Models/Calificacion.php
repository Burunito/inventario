<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = "calificaciones";

    protected $fillable = [
        'producto_id',
        'calificacion'
    ];

    public function productos()
    {
        return $this->belongsTo(Categoria::class);
    }
}
