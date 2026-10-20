<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    protected $table='cliente';

    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'telefono',
        'correo',
        'puntos',

    ];

    public function factura(){
        return $this->hasMany(factura::class);
    }
}

