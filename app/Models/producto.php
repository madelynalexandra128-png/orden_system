<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    protected $table='producto';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'precioCompra',
        'stock',
        'estado',
        'puntos',
        'imagen',
        'idCategoria'
    ];

    public function categoria(){
        return $this->belongsTo(categoria::class, 'idCategoria');
    }
}
