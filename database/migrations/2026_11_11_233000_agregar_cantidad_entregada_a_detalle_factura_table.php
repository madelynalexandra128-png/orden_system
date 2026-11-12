<?php

namespace App\Http\Controllers;

use App\Models\cliente;
use Illuminate\Http\Request;

class ClienteAccesoController extends Controller
{
    public function formulario(string $codigoQr)
    {
        return view('Login.Index', compact('codigoQr'));
    }

    public function iniciarSesion(Request $request, string $codigoQr)
    {
        $request->validate([
            'cedula' => ['required', 'string']
        ], [
            'cedula.required' => 'Debes ingresar tu número de cédula.'
        ]);

        $cliente = cliente::where('cedula', $request->cedula)->first();

        if (!$cliente) {
            return back()
                ->withInput()
                ->withErrors([
                    'cedula' => 'No encontramos un cliente registrado con esa cédula.'
                ]);
        }

        session([
            'cliente_id' => $cliente->id
        ]);

        return redirect()->route('menu.inicio', [
            'codigoQr' => $codigoQr
        ]);
    }

    public function cerrarSesion()
    {
        session()->forget('cliente_id');

        return redirect()->route('home');
    }
}
