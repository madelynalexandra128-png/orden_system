<?php

namespace App\Http\Controllers;

use App\Models\mesa;
use App\Services\MesaService;
use Illuminate\Http\Request;

class MesaController extends Controller
{

    private MesaService $mesaService;

    public function __construct(MesaService $mesaService) {
        $this->mesaService=$mesaService;

    }
    
    public function index()
    {
        $mesas = $this->mesaService->listarMesas();
        return view('Mesas.Index',compact('mesas'));
    }

    
    public function create()
    {
        return view('Mesas.Create');
    }

    
    public function store(Request $request)
    {
        $this->mesaService->guardarMesas($request->all());

        return redirect()->route('mesa.index');
    }

    
    public function show()
    {
        //
    }

    
    public function edit(int $id)
    {
        $mesas=$this->mesaService->budcarIdMesa($id);

        return view('Mesas.Edit',compact('mesas'));
    }

    
    public function update(int $id, Request $request)
    {
        $this->mesaService->actualizarMesa($id, $request->all());
        return redirect()->route('mesa.index');
    }
    
    public function destroy(int $id)
    {
        $this->mesaService->eliminarMesa($id);

        return redirect()->route('mesa.index');
    }
}
