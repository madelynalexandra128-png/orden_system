<?php

namespace App\Repositories;

use App\Http\Controllers\MesaController;
use App\Models\mesa;

class MesaRepository{

    public function listarMesas()
    {
        $mesas = mesa::all();
        return $mesas;
    }

    public function guardarMesas(array $datos)
    {
        mesa::create($datos);
    }

    public function budcarIdMesa(int $id)
    {
        $mesas=mesa::findOrFail($id);
        return $mesas;
    }

    public function actualizarMesa(int $id , array $datos)
    {
        $mesas=mesa::findOrFail($id);
        $mesas->update($datos);
        return $mesas;
    }

    public function eliminarMesa(int $id)
    {
        mesa::destroy($id);
    }
}