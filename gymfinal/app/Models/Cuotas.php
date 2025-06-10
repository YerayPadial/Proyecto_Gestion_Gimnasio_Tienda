<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cuotas extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'precio',
        'descripcion',
    ];
}