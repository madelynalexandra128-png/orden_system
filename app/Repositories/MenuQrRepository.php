<?php

namespace App\Repositories;

use App\Models\categoria;
use App\Models\mesa;

class MenuQrRepository{

    public function buscarMesaPorCodigo(string $codigoQr)
    {
        return mesa::where('codigoQr', $codigoQr)->firstOrFail();
    }

    public function listarCategoriasDisponibles()
    {
        return categoria::where('estado', 1)
            ->whereHas('producto', function ($consulta) {
                $consulta->where('estado', 1)
                    ->where('stock', '>', 0);
            })
            ->get();
    }
}