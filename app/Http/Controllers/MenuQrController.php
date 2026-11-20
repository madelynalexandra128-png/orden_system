<?php

namespace App\Http\Controllers;

use App\Models\AccesoQr;
use App\Models\mesa;
use App\Services\MenuQrService;
use App\Services\MesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuQrController extends Controller
{

    private MenuQrService $menuQrService;

    public function __construct(MenuQrService $menuQrService) 
    {
        return $this->menuQrService= $menuQrService;
    }


    public function inicio(string $codigoQr, Request $request)
    {
        return DB::transaction(function () use ($codigoQr, $request) {

            $mesa = mesa::where('codigoQr', $codigoQr)
                ->lockForUpdate()
                ->firstOrFail();

            // Libera los celulares que ya superaron los 10 minutos.
            $this->liberarAccesosVencidos($mesa);

            // Cada navegador o celular recibe un token propio para esta mesa.
            $claveToken = 'token_qr_mesa_' . $mesa->id;

            $token = $request->session()->get($claveToken);

            if (!$token) {
                $token = (string) Str::uuid();

                $request->session()->put($claveToken, $token);
            }

            $acceso = AccesoQr::where('token', $token)
                ->lockForUpdate()
                ->first();

            // Si ya hizo un pedido, conserva el acceso hasta que se pague.
            if ($acceso && $acceso->estado === 'pedido') {
                return view('Qr.Index', compact('mesa'));
            }

            // Si ya estaba activo, renueva sus 10 minutos.
            if ($acceso && $acceso->estado === 'activo') {
                $acceso->update([
                    'venceEn' => now()->addMinutes(10),
                ]);

                return view('Qr.Index', compact('mesa'));
            }

            // Cuenta los cupos ocupados antes de permitir otro celular.
            $cuposOcupados = AccesoQr::where('idMesa', $mesa->id)
                ->whereIn('estado', ['activo', 'pedido'])
                ->count();

            if ($cuposOcupados >= $mesa->capacidad) {
                return response('La mesa ya alcanzó su capacidad.', 403);
            }

            $datosAcceso = [
                'idMesa' => $mesa->id,
                'estado' => 'activo',
                'venceEn' => now()->addMinutes(10),
            ];

            // Si el celular había vencido, reactiva su mismo registro.
            if ($acceso) {
                $acceso->update($datosAcceso);
            } else {
                AccesoQr::create([
                    ...$datosAcceso,
                    'token' => $token,
                ]);
            }

            // Actualiza el contador visible de la mesa.
            $mesa->update([
                'escaneosActivos' => $cuposOcupados + 1,
                'estado' => 'Ocupada',
            ]);

            return view('Qr.Index', compact('mesa'));
        });
    }

    private function liberarAccesosVencidos(mesa $mesa): void
    {
        // Cambia a expirados los accesos que no hicieron pedido en 10 minutos.
        AccesoQr::where('idMesa', $mesa->id)
            ->where('estado', 'activo')
            ->where('venceEn', '<=', now())
            ->update([
                'estado' => 'expirado',
            ]);

        // Cuenta los cupos que siguen ocupados.
        $cuposOcupados = AccesoQr::where('idMesa', $mesa->id)
            ->whereIn('estado', ['activo', 'pedido'])
            ->count();

        // Revisa si hay una factura pendiente.
        $tieneFacturaPendiente = $mesa->factura()
            ->where('estado', 'pendiente')
            ->exists();

        $mesa->update([
            'escaneosActivos' => $cuposOcupados,
            'estado' => ($cuposOcupados > 0 || $tieneFacturaPendiente)
                ? 'Ocupada'
                : 'Disponible',
        ]);
    }

    public function productos(string $codigoQr)
    {
        return view('MenuCliente.Index', compact('codigoQr'));
    }
}