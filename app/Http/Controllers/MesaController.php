<?php

namespace App\Http\Controllers;

use App\Models\mesa;
use App\Services\MesaService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


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

    private function generarQr(mesa $mesa, int $tamano = 500): string
    {
        $urlMenu = url('/menu/' . $mesa->codigoQr);

        return QrCode::format('svg')
            ->size($tamano)
            ->margin(1)
            ->generate($urlMenu);
    }

    public function descargarQrImagen(mesa $mesa)
    {
        $urlMenu = url('/menu/' . $mesa->codigoQr);

        $qrPng = QrCode::format('png')
            ->size(1000)
            ->margin(1)
            ->generate($urlMenu);

        return response($qrPng, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="qr-' . $mesa->codigoQr . '.png"',
        ]);
    }

    public function descargarQrPdf(mesa $mesa)
    {
        $qrSvg = $this->generarQr($mesa);

        return Pdf::loadView('Mesas.QrPdf', compact('mesa', 'qrSvg'))
            ->setPaper('a5', 'portrait')
            ->download('qr-' . $mesa->codigoQr . '.pdf');
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
