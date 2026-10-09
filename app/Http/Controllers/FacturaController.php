<?php

namespace App\Http\Controllers;

use App\Models\factura;
use App\Services\ClienteService;
use App\Services\FacturaService;
use App\Services\MesaService;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    
    private FacturaService $facturaService;
    private ClienteService $clienteService;
    private MesaService $mesaService;

    public function __construct(
            FacturaService $facturaService,
            ClienteService $clienteService,
            MesaService $mesaService
        )
    {
        $this->facturaService =$facturaService;
        $this->clienteService=$clienteService;
        $this->mesaService = $mesaService;
    }

    
    public function index()
    {
        $facturas=$this->facturaService->listarFacturas();

        return view('Facturas.Index',compact('facturas'));
    }


    public function create()
    {
        $clientes = $this->clienteService->listarClientes();
        $mesas = $this->mesaService->listarMesas();

        return view('Facturas.Create',compact('clientes','mesas'));

    }

    public function store(Request $request)
    {
        $this->facturaService->guardarFactura($request->all());
        return redirect()->route('factura.index');
    }

    
    public function show()
    {
        
    }

    
    public function edit(int $id)
    {
        $clientes = $this->clienteService->listarClientes();
        $mesas = $this->mesaService->listarMesas();
        $facturas = $this->facturaService->buscasrIdFactura($id);

        return view('Facturas.Edit',compact('facturas','clientes','mesas'));

    }

    
    public function update(int $id,Request $request)
    {
        $this->facturaService->actualizarFactura($id,$request->all());
        return redirect()->route('factura.index');
    }


    public function destroy(int $id)
    {
        $this->facturaService->eliminarFactura($id);
        return redirect()->route('factura.index');
    }
}
