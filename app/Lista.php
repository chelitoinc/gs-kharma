<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    protected $table = "lista";

    protected $fillable = [
        'producto',
        'cantidad',
        'pedido_id'
    ];
}
