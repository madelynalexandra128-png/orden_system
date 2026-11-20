<?php

namespace Database\Seeders;

use App\Models\categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        categoria::firstOrCreate(
            ['nombre' => 'Cafés'],
            [
                'descripcion' => 'Diferentes tipos de café y preparaciones',
                'estado' => 1,
            ]
        );

        categoria::firstOrCreate(
            ['nombre' => 'Bebidas frías'],
            [
                'descripcion' => 'Bebidas frías, granizados y preparaciones con hielo',
                'estado' => 1,
            ]
        );

        categoria::firstOrCreate(
            ['nombre' => 'Bebidas calientes'],
            [
                'descripcion' => 'Chocolate, té y otras bebidas calientes',
                'estado' => 1,
            ]
        );

        categoria::firstOrCreate(
            ['nombre' => 'Empanadas'],
            [
                'descripcion' => 'Empanadas con diferentes rellenos',
                'estado' => 1,
            ]
        );

        categoria::firstOrCreate(
            ['nombre' => 'Panadería'],
            [
                'descripcion' => 'Pan, croissants y productos de panadería',
                'estado' => 1,
            ]
        );

        categoria::firstOrCreate(
            ['nombre' => 'Postres'],
            [
                'descripcion' => 'Postres, tortas y productos dulces',
                'estado' => 1,
            ]
        );

        categoria::firstOrCreate(
            ['nombre' => 'Sandwiches'],
            [
                'descripcion' => 'Sandwiches y preparaciones saladas',
                'estado' => 1,
            ]
        );

        categoria::firstOrCreate(
            ['nombre' => 'Desayunos'],
            [
                'descripcion' => 'Opciones de desayuno y combos',
                'estado' => 1,
            ]
        );

        categoria::firstOrCreate(
            ['nombre' => 'Combos'],
            [
                'descripcion' => 'Combinaciones de productos a precio especial',
                'estado' => 1,
            ]
        );

        categoria::firstOrCreate(
            ['nombre' => 'Snacks'],
            [
                'descripcion' => 'Productos pequeños para acompañar las bebidas',
                'estado' => 1,
            ]
        );

        categoria::firstOrCreate(
            ['nombre' => 'Jugos naturales'],
            [
                'descripcion' => 'Jugos preparados con frutas naturales',
                'estado' => 1,
            ]
        );

        categoria::firstOrCreate(
            ['nombre' => 'Aguas'],
            [
                'descripcion' => 'Agua y otras bebidas embotelladas',
                'estado' => 1,
            ]
        );
    }
}
