<?php

namespace Database\Seeders;

use App\Models\cliente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class clienteseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        cliente::create([
            'nombre'   => 'Juan',
            'apellido' => 'Pérez',
            'cedula'   => '1234567890',
            'telefono' => '3001234567',
            'correo'   => 'juan.perez@example.com',
            'puntos'   => 150,
        ]);

        Cliente::create([
            'nombre'   => 'María',
            'apellido' => 'Gómez',
            'cedula'   => '1234567891',
            'telefono' => '3001234568',
            'correo'   => 'maria.gomez@example.com',
            'puntos'   => 250,
        ]);

        Cliente::create([
            'nombre'   => 'Carlos',
            'apellido' => 'Rodríguez',
            'cedula'   => '1234567892',
            'telefono' => '3001234569',
            'correo'   => 'carlos.rodriguez@example.com',
            'puntos'   => 80,
        ]);

        Cliente::create([
            'nombre'   => 'Ana',
            'apellido' => 'Martínez',
            'cedula'   => '1234567893',
            'telefono' => '3001234570',
            'correo'   => 'ana.martinez@example.com',
            'puntos'   => 320,
        ]);

        Cliente::create([
            'nombre'   => 'Luis',
            'apellido' => 'Fernández',
            'cedula'   => '1234567894',
            'telefono' => '3001234571',
            'correo'   => 'luis.fernandez@example.com',
            'puntos'   => 180,
        ]);

        Cliente::create([
            'nombre'   => 'Laura',
            'apellido' => 'Ramírez',
            'cedula'   => '1234567895',
            'telefono' => '3001234572',
            'correo'   => 'laura.ramirez@example.com',
            'puntos'   => 210,
        ]);

        Cliente::create([
            'nombre'   => 'Pedro',
            'apellido' => 'Torres',
            'cedula'   => '1234567896',
            'telefono' => '3001234573',
            'correo'   => 'pedro.torres@example.com',
            'puntos'   => 130,
        ]);

        Cliente::create([
            'nombre'   => 'Sofía',
            'apellido' => 'Castro',
            'cedula'   => '1234567897',
            'telefono' => '3001234574',
            'correo'   => 'sofia.castro@example.com',
            'puntos'   => 400,
        ]);

        Cliente::create([
            'nombre'   => 'Andrés',
            'apellido' => 'Vargas',
            'cedula'   => '1234567898',
            'telefono' => '3001234575',
            'correo'   => 'andres.vargas@example.com',
            'puntos'   => 90,
        ]);

        Cliente::create([
            'nombre'   => 'Camila',
            'apellido' => 'Moreno',
            'cedula'   => '1234567899',
            'telefono' => '3001234576',
            'correo'   => 'camila.moreno@example.com',
            'puntos'   => 275,
        ]);

        Cliente::create([
            'nombre'   => 'Diego',
            'apellido' => 'Herrera',
            'cedula'   => '1234567800',
            'telefono' => '3001234577',
            'correo'   => 'diego.herrera@example.com',
            'puntos'   => 140,
        ]);

        Cliente::create([
            'nombre'   => 'Valentina',
            'apellido' => 'Rojas',
            'cedula'   => '1234567801',
            'telefono' => '3001234578',
            'correo'   => 'valentina.rojas@example.com',
            'puntos'   => 350,
        ]);

        Cliente::create([
            'nombre'   => 'Jorge',
            'apellido' => 'Navarro',
            'cedula'   => '1234567802',
            'telefono' => '3001234579',
            'correo'   => 'jorge.navarro@example.com',
            'puntos'   => 170,
        ]);

        Cliente::create([
            'nombre'   => 'Paula',
            'apellido' => 'Mendoza',
            'cedula'   => '1234567803',
            'telefono' => '3001234580',
            'correo'   => 'paula.mendoza@example.com',
            'puntos'   => 220,
        ]);

        Cliente::create([
            'nombre'   => 'Miguel',
            'apellido' => 'Ortega',
            'cedula'   => '1234567804',
            'telefono' => '3001234581',
            'correo'   => 'miguel.ortega@example.com',
            'puntos'   => 95,
        ]);
    }
}
