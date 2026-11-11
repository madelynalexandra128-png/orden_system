<?php


namespace App\Services;

use App\Repositories\MesaRepository;

class MesaService{

    private MesaRepository $mesaRepository;

    public function __construct(MesaRepository $mesaRepository) 
    {
        $this->mesaRepository=$mesaRepository;
    }

    public function listarMesas()
    {
        return $this->mesaRepository->listarMesas();
    }

    public function guardarMesas(array $datos)
    {
        // Primero se guarda para que Laravel genere el ID.
        $mesa = $this->mesaRepository->guardarMesas([
            'nombre' => 'Mesa temporal',
            'capacidad' => $datos['capacidad'],
            'estado' => 'Disponible',
            'codigoQr' => 'pendiente',
        ]);

        // Con el ID creado se forma el nombre y código definitivos.
        $mesa->update([
            'nombre' => 'Mesa ' . $mesa->id,
            'codigoQr' => 'MESA-' . $mesa->id,
        ]);

        return $mesa;
    }

    public function budcarIdMesa(int $id){
        return $this->mesaRepository->budcarIdMesa($id);
    }

    public function actualizarMesa(int $id,array $datos)
    {
        return $this->mesaRepository->actualizarMesa($id,$datos);

    }

    public function eliminarMesa(int $id)
    {
        return $this->mesaRepository->eliminarMesa($id);
    }
}