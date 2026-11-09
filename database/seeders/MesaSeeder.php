<?php

namespace Database\Seeders;

use App\Models\mesa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    mesa::create([
        'nombre' => 'Mesa 1',
        'capacidad' => 2,
        'estado' => 'Disponible',
        'codigoQr' => 'QR001',
    ]);

    Mesa::create([
        'nombre' => 'Mesa 2',
        'capacidad' => 4,
        'estado' => 'Ocupada',
        'codigoQr' => 'QR002',
    ]);

    Mesa::create([
        'nombre' => 'Mesa 3',
        'capacidad' => 6,
        'estado' => 'Disponible',
        'codigoQr' => 'QR003',
    ]);

    Mesa::create([
        'nombre' => 'Mesa 4',
        'capacidad' => 8,
        'estado' => 'Reservada',
        'codigoQr' => 'QR004',
    ]);

    Mesa::create([
        'nombre' => 'Mesa 5',
        'capacidad' => 4,
        'estado' => 'Disponible',
        'codigoQr' => 'QR005',
    ]);

    Mesa::create([
        'nombre' => 'Mesa 6',
        'capacidad' => 2,
        'estado' => 'Mantenimiento',
        'codigoQr' => 'QR006',
    ]);

    Mesa::create([
        'nombre' => 'Mesa 7',
        'capacidad' => 10,
        'estado' => 'Disponible',
        'codigoQr' => 'QR007',
    ]);

    Mesa::create([
        'nombre' => 'Mesa 8',
        'capacidad' => 6,
        'estado' => 'Ocupada',
        'codigoQr' => 'QR008',
    ]);

    Mesa::create([
        'nombre' => 'Mesa 9',
        'capacidad' => 4,
        'estado' => 'Disponible',
        'codigoQr' => 'QR009',
    ]);

    Mesa::create([
        'nombre' => 'Mesa 10',
        'capacidad' => 8,
        'estado' => 'Reservada',
        'codigoQr' => 'QR010',
    ]);

    Mesa::create([
        'nombre' => 'Mesa 11',
        'capacidad' => 2,
        'estado' => 'Disponible',
        'codigoQr' => 'QR011',
    ]);

    Mesa::create([
        'nombre' => 'Mesa 12',
        'capacidad' => 4,
        'estado' => 'Ocupada',
        'codigoQr' => 'QR012',
    ]);

    Mesa::create([
        'nombre' => 'Mesa 13',
        'capacidad' => 6,
        'estado' => 'Disponible',
        'codigoQr' => 'QR013',
    ]);

    Mesa::create([
        'nombre' => 'Mesa 14',
        'capacidad' => 12,
        'estado' => 'Reservada',
        'codigoQr' => 'QR014',
    ]);

    Mesa::create([
        'nombre' => 'Mesa 15',
        'capacidad' => 4,
        'estado' => 'Disponible',
        'codigoQr' => 'QR015',
    ]);
    }
}
