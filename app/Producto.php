<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = "producto";
    
    protected $fillable = [
        'nombre',
        'fechaCompra',
        'stock',
        'precioC',
        'precioV',
        'descripcion',
        'imgProducto',
        'categoria_id',
        'proveedor_id'

    ];
}
