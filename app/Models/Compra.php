<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras';

    protected $fillable = [
        'fecha',
        'proveedor',
        'producto',
        'cantidad',
        'precio_unitario',
        'total',
        'estado',
        'observaciones'
    ];

    protected $casts = [
        'fecha' => 'date:Y-m-d',
        'precio_unitario' => 'decimal:2',
        'total' => 'decimal:2'
    ];
} 