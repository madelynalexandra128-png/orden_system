<?php

namespace App\Http\Controllers;

use App\Models\cliente;
use App\Services\ClienteService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClienteController extends Controller
{

    private ClienteService $clienteService;

    public function __construct(ClienteService $clienteService) {

        $this->clienteService = $clienteService;
        
    }
    
    public function index()
    {
        $clientes = $this->clienteService->listarClientes();

        return view('Clientes.Index',compact('clientes'));
    }


    public function create()
    {
        return view('Clientes.Create');
    }

    public function store(Request $request)
    {
        $this->clienteService->guardarCliente($request->all());
        return redirect()->route('cliente.index');
    }

    
    public function show()
    {

    }

    public function edit(int $id)
    {
        $clientes=$this->clienteService->buscarPorIdCliente($id);

        return view('Clientes.Edit',compact('clientes'));
    }

    public function update(int $id,Request $request)
    {
        $this->clienteService->actualizarCliente($id,$request->all());

        return redirect()->route('cliente.index');
    }

    public function destroy(int $id )
    {
        $this->clienteService->eliminarCliente($id);
        return redirect()->route('cliente.index')->with('success', 'eliminada correctamente');
    }
}
