<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = "pedido";

    protected $fillable = [
        'nombre',
        'user_id',
        'proveedor_id'
    ];
}
