<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mesa extends Model
{
    protected $table = 'mesa';

    protected $fillable = [
        'nombre',
        'capacidad',
        'estado',
        'codigoQr'
    ];
}
