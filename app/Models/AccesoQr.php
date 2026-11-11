<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccesoQr extends Model
{
    protected $table = 'accesoQr';

    protected $fillable = [
        'idMesa',
        'token',
        'estado',
        'venceEn',
    ];

    protected function casts(): array
    {
        return [
            'venceEn' => 'datetime',
        ];
    }

    public function mesa()
    {
        return $this->belongsTo(mesa::class, 'idMesa');
    }
}
