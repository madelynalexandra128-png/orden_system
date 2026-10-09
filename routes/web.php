<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

//categoria
Route::resource('categoria',CategoriaController::class);
Route::post('/categoria/cambiarEstado/{id}',[CategoriaController::class, 'cambiar'])->name('categoria.canbiarEstado');

//producto
Route::resource('/producto',ProductoController::class);
Route::post('/producto/cambiarEstadoProducto/{id}',[ProductoController::class,'cambiarEstadoProducto'])->name('producto.canbiarEstadoProducto');

//cliente 
Route::resource('/cliente',ClienteController::class);

//mesas

Route::resource('/mesa',MesaController::class);

//factura
Route::resource('/factura',FacturaController::class);
