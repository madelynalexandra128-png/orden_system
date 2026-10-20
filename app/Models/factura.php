<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class factura extends Model
{
    protected $table='factura';

    protected $fillable = [
        'idCliente',
        'idMesa',
        'metodoPago',
        'estado',
        'fecha',
        'total'
    ];

    public function cliente(){
        return $this->belongsTo(cliente::class, 'idCliente');
    }

    public function mesa(){
        return $this->belongsTo(mesa::class,'idMesa');
    }
}
