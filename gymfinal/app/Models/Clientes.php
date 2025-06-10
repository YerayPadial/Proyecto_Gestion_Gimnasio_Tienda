<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clientes extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellidos',
        'dni',
        'email',
        'telefono',
        'fecha_inicio',
        'fecha_caducidad',
        'tipo_cuota',
        'foto',
    ];

    public function cuota()
    {
        return $this->belongsTo(Cuotas::class, 'tipo_cuota');
    }
}