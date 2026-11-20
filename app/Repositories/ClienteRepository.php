<?php

namespace App\Repositories;

use App\Models\cliente;

class ClienteRepository{

    public function listarClientes(){

        $clientes = cliente::all();
        return $clientes;

    }

    public function guardarCliente(array $datos){
        cliente::create($datos);
    }

    public function buscarPorIdCliente(int $id){
        $clientes =cliente::findOrFail($id);
        return $clientes;
    }

    public function actualizarCliente(int $id,array $datos){
        $clientes=cliente::findOrFail($id);
        $clientes-> update($datos);
        return $clientes;
    }

    public function eliminarCliente(int $id){
        cliente::destroy($id);
    }
    
}