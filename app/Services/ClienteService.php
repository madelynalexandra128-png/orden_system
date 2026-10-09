<?php

namespace App\Services;

use App\Repositories\ClienteRepository;

class ClienteService{

    private ClienteRepository $clienteRepository;

    public function __construct(ClienteRepository $clienteRepository) {

        return $this->clienteRepository = $clienteRepository;
    
    }

    public function listarClientes(){
        return $this->clienteRepository->listarClientes();
    }

    public function guardarCliente(array $datos){
        return $this->clienteRepository->guardarCliente($datos);
    }

    public function buscarPorIdCliente(int $id){
        return $this->clienteRepository->buscarPorIdCliente($id);
    }

    public function actualizarCliente(int $id,array $datos){
        return $this->clienteRepository->actualizarCliente($id,$datos);
    }

    public function eliminarCliente(int $id){
        return $this->clienteRepository->eliminarCliente($id);
    }


}