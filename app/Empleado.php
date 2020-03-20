<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = "users";
    
    protected $fillable = [
        'name', 
        'apellidos',  
        'domicilio',
        'cp',
        'ine',
        'telefono',
        'email', 
        'password',
        'imagen'
    ];
}
