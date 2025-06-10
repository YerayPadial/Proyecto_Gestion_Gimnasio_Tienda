<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Orders extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'reference',
        'name',
        'email',
        'dni',
        'phone',
        'country',
        'province',
        'municipality',
        'postal_code',
        'street',
        'street_number',
        'total_price',
        'ordered_at',
        'shipped_at',
        'status',
        'shipping_method',
    ];

    protected $dates = [
        'ordered_at',
        'shipped_at',
    ];

    protected $casts = [
        'ordered_at' => 'datetime',
    ];

    // Relación: un pedido tiene muchos ítems

    public function items()
    {
        return $this->hasMany(order_items::class, 'order_id');
    }
}
