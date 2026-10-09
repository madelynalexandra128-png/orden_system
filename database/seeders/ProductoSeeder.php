<?php

namespace Database\Seeders;

use App\Models\producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        producto::create([
            'nombre' => 'Espresso',
            'descripcion' => 'Café concentrado de sabor intenso',
            'precio' => 2.50,
            'precioCompra' => 1.00,
            'stock' => 100,
            'estado' => 1,
            'puntos' => 10,
            'idCategoria' => 1, // Cafés
        ]);

        Producto::create([
            'nombre' => 'Frappé de Caramelo',
            'descripcion' => 'Bebida fría con café y caramelo',
            'precio' => 5.50,
            'precioCompra' => 2.80,
            'stock' => 50,
            'estado' => 1,
            'puntos' => 20,
            'idCategoria' => 2, // Bebidas frías
        ]);

        Producto::create([
            'nombre' => 'Chocolate Caliente',
            'descripcion' => 'Chocolate caliente tradicional',
            'precio' => 3.50,
            'precioCompra' => 1.50,
            'stock' => 60,
            'estado' => 1,
            'puntos' => 15,
            'idCategoria' => 3, // Bebidas calientes
        ]);

        Producto::create([
            'nombre' => 'Empanada de Carne',
            'descripcion' => 'Empanada rellena de carne sazonada',
            'precio' => 2.00,
            'precioCompra' => 0.80,
            'stock' => 80,
            'estado' => 1,
            'puntos' => 8,
            'idCategoria' => 4, // Empanadas
        ]);

        Producto::create([
            'nombre' => 'Croissant de Mantequilla',
            'descripcion' => 'Croissant recién horneado',
            'precio' => 2.80,
            'precioCompra' => 1.20,
            'stock' => 40,
            'estado' => 1,
            'puntos' => 10,
            'idCategoria' => 5, // Panadería
        ]);

        Producto::create([
            'nombre' => 'Cheesecake',
            'descripcion' => 'Tarta de queso con salsa de frutos rojos',
            'precio' => 4.50,
            'precioCompra' => 2.00,
            'stock' => 25,
            'estado' => 1,
            'puntos' => 18,
            'idCategoria' => 6, // Postres
        ]);

        Producto::create([
            'nombre' => 'Sándwich de Pollo',
            'descripcion' => 'Pollo, lechuga y tomate en pan artesanal',
            'precio' => 6.50,
            'precioCompra' => 3.00,
            'stock' => 30,
            'estado' => 1,
            'puntos' => 25,
            'idCategoria' => 7, // Sandwiches
        ]);

        Producto::create([
            'nombre' => 'Desayuno Tradicional',
            'descripcion' => 'Café, tostadas y huevos',
            'precio' => 7.50,
            'precioCompra' => 3.50,
            'stock' => 20,
            'estado' => 1,
            'puntos' => 30,
            'idCategoria' => 8, // Desayunos
        ]);

        Producto::create([
            'nombre' => 'Combo Café + Croissant',
            'descripcion' => 'Promoción especial de desayuno',
            'precio' => 4.99,
            'precioCompra' => 2.20,
            'stock' => 50,
            'estado' => 1,
            'puntos' => 15,
            'idCategoria' => 9, // Combos
        ]);
    }
}
