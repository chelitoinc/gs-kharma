<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = "empresa";

    protected $fillable = [
        'nombre', 
        'director',  
        'domicilio',
        'estado',
        'pais',
        'cp',
        'giro',
        'telefono',
        'email',
        'logo',
        'user_id'
    ];
}
