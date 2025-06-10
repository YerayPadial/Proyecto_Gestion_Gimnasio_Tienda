<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'precio',
        'existencias',
        'descripcion',
        'tipo_categoria',
        'foto',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categorias::class, 'tipo_categoria');
    }
}
