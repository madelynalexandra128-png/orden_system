<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detalleFactura extends Model
{
    protected $table='detalleFactura';

    protected $fillable = [
        'idFactura',
        'idProducto',
        'cantidad',
        'precioUnitario',
        'total'
    ];

    public function factura(){
        return $this->belongsTo(factura::class,'idFactura');
    }

    public function producto(){
        return $this->belongsTo(producto::class, 'idProducto');
    }
}
