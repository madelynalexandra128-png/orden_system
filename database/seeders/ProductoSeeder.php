<?php

namespace Database\Seeders;

use App\Models\producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [

            // CAFÉS - idCategoria 1
            ['nombre' => 'Café Americano', 'descripcion' => 'Café espresso diluido con agua caliente', 'precio' => 5000, 'precioCompra' => 2000, 'stock' => 30, 'estado' => 1, 'puntos' => 5, 'imagen' => null, 'idCategoria' => 1],
            ['nombre' => 'Café Latte', 'descripcion' => 'Café espresso con leche vaporizada', 'precio' => 7500, 'precioCompra' => 3500, 'stock' => 25, 'estado' => 1, 'puntos' => 7, 'imagen' => null, 'idCategoria' => 1],
            ['nombre' => 'Capuchino', 'descripcion' => 'Café espresso con leche y espuma', 'precio' => 8000, 'precioCompra' => 3800, 'stock' => 20, 'estado' => 1, 'puntos' => 8, 'imagen' => null, 'idCategoria' => 1],

            // BEBIDAS FRÍAS - idCategoria 2
            ['nombre' => 'Frappé de Café', 'descripcion' => 'Bebida fría de café con hielo', 'precio' => 10000, 'precioCompra' => 4500, 'stock' => 20, 'estado' => 1, 'puntos' => 10, 'imagen' => null, 'idCategoria' => 2],
            ['nombre' => 'Limonada Natural', 'descripcion' => 'Limonada preparada con limón natural', 'precio' => 6000, 'precioCompra' => 2500, 'stock' => 25, 'estado' => 1, 'puntos' => 6, 'imagen' => null, 'idCategoria' => 2],
            ['nombre' => 'Granizado de Mora', 'descripcion' => 'Bebida granizada sabor a mora', 'precio' => 7000, 'precioCompra' => 3000, 'stock' => 20, 'estado' => 1, 'puntos' => 7, 'imagen' => null, 'idCategoria' => 2],

            // BEBIDAS CALIENTES - idCategoria 3
            ['nombre' => 'Chocolate Caliente', 'descripcion' => 'Chocolate preparado con leche', 'precio' => 6500, 'precioCompra' => 2800, 'stock' => 20, 'estado' => 1, 'puntos' => 6, 'imagen' => null, 'idCategoria' => 3],
            ['nombre' => 'Té de Frutos Rojos', 'descripcion' => 'Infusión caliente de frutos rojos', 'precio' => 5000, 'precioCompra' => 1800, 'stock' => 25, 'estado' => 1, 'puntos' => 5, 'imagen' => null, 'idCategoria' => 3],
            ['nombre' => 'Aromática', 'descripcion' => 'Infusión caliente de hierbas naturales', 'precio' => 4000, 'precioCompra' => 1500, 'stock' => 25, 'estado' => 1, 'puntos' => 4, 'imagen' => null, 'idCategoria' => 3],

            // EMPANADAS - idCategoria 4
            ['nombre' => 'Empanada de Carne', 'descripcion' => 'Empanada tradicional rellena de carne', 'precio' => 3500, 'precioCompra' => 1800, 'stock' => 30, 'estado' => 1, 'puntos' => 3, 'imagen' => null, 'idCategoria' => 4],
            ['nombre' => 'Empanada de Pollo', 'descripcion' => 'Empanada rellena de pollo desmechado', 'precio' => 3500, 'precioCompra' => 1800, 'stock' => 30, 'estado' => 1, 'puntos' => 3, 'imagen' => null, 'idCategoria' => 4],
            ['nombre' => 'Empanada de Queso', 'descripcion' => 'Empanada rellena de queso', 'precio' => 3000, 'precioCompra' => 1500, 'stock' => 25, 'estado' => 1, 'puntos' => 3, 'imagen' => null, 'idCategoria' => 4],

            // PANADERÍA - idCategoria 5
            ['nombre' => 'Croissant', 'descripcion' => 'Pan de hojaldre tradicional', 'precio' => 4500, 'precioCompra' => 2200, 'stock' => 20, 'estado' => 1, 'puntos' => 4, 'imagen' => null, 'idCategoria' => 5],
            ['nombre' => 'Pan de Queso', 'descripcion' => 'Pan horneado relleno de queso', 'precio' => 3500, 'precioCompra' => 1600, 'stock' => 25, 'estado' => 1, 'puntos' => 3, 'imagen' => null, 'idCategoria' => 5],
            ['nombre' => 'Almojábana', 'descripcion' => 'Pan tradicional colombiano de queso', 'precio' => 3000, 'precioCompra' => 1400, 'stock' => 25, 'estado' => 1, 'puntos' => 3, 'imagen' => null, 'idCategoria' => 5],

            // POSTRES - idCategoria 6
            ['nombre' => 'Brownie', 'descripcion' => 'Brownie de chocolate artesanal', 'precio' => 6000, 'precioCompra' => 2500, 'stock' => 15, 'estado' => 1, 'puntos' => 6, 'imagen' => null, 'idCategoria' => 6],
            ['nombre' => 'Cheesecake', 'descripcion' => 'Torta cremosa de queso', 'precio' => 8500, 'precioCompra' => 4000, 'stock' => 12, 'estado' => 1, 'puntos' => 8, 'imagen' => null, 'idCategoria' => 6],
            ['nombre' => 'Torta de Chocolate', 'descripcion' => 'Porción de torta húmeda de chocolate', 'precio' => 7000, 'precioCompra' => 3200, 'stock' => 15, 'estado' => 1, 'puntos' => 7, 'imagen' => null, 'idCategoria' => 6],

            // SANDWICHES - idCategoria 7
            ['nombre' => 'Sándwich de Pollo', 'descripcion' => 'Pan con pollo, queso y vegetales', 'precio' => 12000, 'precioCompra' => 6000, 'stock' => 15, 'estado' => 1, 'puntos' => 12, 'imagen' => null, 'idCategoria' => 7],
            ['nombre' => 'Sándwich de Jamón y Queso', 'descripcion' => 'Pan con jamón y queso', 'precio' => 9000, 'precioCompra' => 4200, 'stock' => 15, 'estado' => 1, 'puntos' => 9, 'imagen' => null, 'idCategoria' => 7],
            ['nombre' => 'Sándwich Especial', 'descripcion' => 'Pan con pollo, jamón, queso y vegetales', 'precio' => 14000, 'precioCompra' => 7000, 'stock' => 12, 'estado' => 1, 'puntos' => 14, 'imagen' => null, 'idCategoria' => 7],

            // DESAYUNOS - idCategoria 8
            ['nombre' => 'Calentado', 'descripcion' => 'Arroz, fríjoles, huevo y arepa', 'precio' => 12000, 'precioCompra' => 6000, 'stock' => 12, 'estado' => 1, 'puntos' => 12, 'imagen' => null, 'idCategoria' => 8],
            ['nombre' => 'Desayuno Campesino', 'descripcion' => 'Huevos, arepa, queso y chocolate', 'precio' => 15000, 'precioCompra' => 7500, 'stock' => 12, 'estado' => 1, 'puntos' => 15, 'imagen' => null, 'idCategoria' => 8],
            ['nombre' => 'Huevos al Gusto', 'descripcion' => 'Huevos preparados con arepa y bebida', 'precio' => 10000, 'precioCompra' => 4500, 'stock' => 15, 'estado' => 1, 'puntos' => 10, 'imagen' => null, 'idCategoria' => 8],

            // COMBOS - idCategoria 9
            ['nombre' => 'Combo Americano', 'descripcion' => 'Café americano y croissant', 'precio' => 8500, 'precioCompra' => 4000, 'stock' => 15, 'estado' => 1, 'puntos' => 8, 'imagen' => null, 'idCategoria' => 9],
            ['nombre' => 'Combo Desayuno', 'descripcion' => 'Huevos, arepa y chocolate', 'precio' => 18000, 'precioCompra' => 9000, 'stock' => 12, 'estado' => 1, 'puntos' => 18, 'imagen' => null, 'idCategoria' => 9],
            ['nombre' => 'Combo Merienda', 'descripcion' => 'Jugo natural y sándwich', 'precio' => 16000, 'precioCompra' => 8000, 'stock' => 12, 'estado' => 1, 'puntos' => 16, 'imagen' => null, 'idCategoria' => 9],

            // SNACKS - idCategoria 10
            ['nombre' => 'Papas Fritas', 'descripcion' => 'Porción de papas fritas', 'precio' => 7000, 'precioCompra' => 3000, 'stock' => 20, 'estado' => 1, 'puntos' => 7, 'imagen' => null, 'idCategoria' => 10],
            ['nombre' => 'Nachos con Queso', 'descripcion' => 'Nachos acompañados de salsa de queso', 'precio' => 8000, 'precioCompra' => 3500, 'stock' => 15, 'estado' => 1, 'puntos' => 8, 'imagen' => null, 'idCategoria' => 10],
            ['nombre' => 'Galletas', 'descripcion' => 'Porción de galletas surtidas', 'precio' => 4000, 'precioCompra' => 1800, 'stock' => 20, 'estado' => 1, 'puntos' => 4, 'imagen' => null, 'idCategoria' => 10],

            // JUGOS NATURALES - idCategoria 11
            ['nombre' => 'Jugo de Mora', 'descripcion' => 'Jugo natural de mora en agua o leche', 'precio' => 7000, 'precioCompra' => 3000, 'stock' => 20, 'estado' => 1, 'puntos' => 7, 'imagen' => null, 'idCategoria' => 11],
            ['nombre' => 'Jugo de Mango', 'descripcion' => 'Jugo natural de mango', 'precio' => 6500, 'precioCompra' => 2800, 'stock' => 20, 'estado' => 1, 'puntos' => 6, 'imagen' => null, 'idCategoria' => 11],
            ['nombre' => 'Jugo de Fresa', 'descripcion' => 'Jugo natural de fresa', 'precio' => 7500, 'precioCompra' => 3200, 'stock' => 20, 'estado' => 1, 'puntos' => 7, 'imagen' => null, 'idCategoria' => 11],

            // AGUAS - idCategoria 12
            ['nombre' => 'Agua sin Gas', 'descripcion' => 'Agua embotellada sin gas', 'precio' => 3000, 'precioCompra' => 1500, 'stock' => 30, 'estado' => 1, 'puntos' => 3, 'imagen' => null, 'idCategoria' => 12],
            ['nombre' => 'Agua con Gas', 'descripcion' => 'Agua mineral con gas', 'precio' => 4000, 'precioCompra' => 2000, 'stock' => 25, 'estado' => 1, 'puntos' => 4, 'imagen' => null, 'idCategoria' => 12],
            ['nombre' => 'Agua Saborizada', 'descripcion' => 'Agua embotellada con sabor a frutas', 'precio' => 4500, 'precioCompra' => 2200, 'stock' => 20, 'estado' => 1, 'puntos' => 4, 'imagen' => null, 'idCategoria' => 12],
        ];

        foreach ($productos as $producto) {
            producto::create($producto);
        }
    }
}
