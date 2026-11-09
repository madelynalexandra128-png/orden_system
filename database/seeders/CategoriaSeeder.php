<?php

namespace Database\Seeders;

use App\Models\categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create([
            'nombre' => 'Cafés',
            'descripcion' => 'Diferentes tipos de café y preparaciones',
            'estado' => 1,
        ]);

        Categoria::create([
            'nombre' => 'Bebidas frías',
            'descripcion' => 'Bebidas frías, granizados y preparaciones con hielo',
            'estado' => 1,
        ]);

        Categoria::create([
            'nombre' => 'Bebidas calientes',
            'descripcion' => 'Chocolate, té y otras bebidas calientes',
            'estado' => 1,
        ]);

        Categoria::create([
            'nombre' => 'Empanadas',
            'descripcion' => 'Empanadas con diferentes rellenos',
            'estado' => 1,
        ]);

        Categoria::create([
            'nombre' => 'Panadería',
            'descripcion' => 'Pan, croissants y productos de panadería',
            'estado' => 1,
        ]);

        Categoria::create([
            'nombre' => 'Postres',
            'descripcion' => 'Postres, tortas y productos dulces',
            'estado' => 1,
        ]);

        Categoria::create([
            'nombre' => 'Sandwiches',
            'descripcion' => 'Sandwiches y preparaciones saladas',
            'estado' => 1,
        ]);

        Categoria::create([
            'nombre' => 'Desayunos',
            'descripcion' => 'Opciones de desayuno y combos',
            'estado' => 1,
        ]);

        Categoria::create([
            'nombre' => 'Combos',
            'descripcion' => 'Combinaciones de productos a precio especial',
            'estado' => 1,
        ]);

        Categoria::create([
            'nombre' => 'Snacks',
            'descripcion' => 'Productos pequeños para acompañar las bebidas',
            'estado' => 1,
        ]);

        Categoria::create([
            'nombre' => 'Jugos naturales',
            'descripcion' => 'Jugos preparados con frutas naturales',
            'estado' => 1,
        ]);

        Categoria::create([
            'nombre' => 'Aguas',
            'descripcion' => 'Agua y otras bebidas embotelladas',
            'estado' => 1,
        ]);
    }
}
