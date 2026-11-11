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

    protected function casts(): array
    {
        return [
            'capacidad' => 'integer',
            'escaneosActivos' => 'integer',
        ];
    }

    public function factura(){
        return $this->hasMany(factura::class, 'idMesa', 'id');
    }


    public function accesosQr()
    {
        return $this->hasMany(AccesoQr::class, 'idMesa');
    }
}
