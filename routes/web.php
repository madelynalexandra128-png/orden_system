<?php

use App\Http\Controllers\BarraController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuQrController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ServicioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/menu/{codigoQr}', [MenuQrController::class, 'inicio'])
    ->name('menu.inicio');

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


//codigo QR
Route::get('/mesa/{mesa}/codigo-qr',[MesaController::class, 'VerQr'])->name('mesa.qr');

Route::get('/mesa/{mesa}/descargar-qr-imagen', [MesaController::class, 'descargarQrImagen'])
    ->name('mesa.descargarQrImagen');

Route::get('/mesa/{mesa}/descargar-qr-pdf', [MesaController::class, 'descargarQrPdf'])
    ->name('mesa.descargarQrPdf');



//factura
Route::resource('/factura',FacturaController::class);


//menu
Route::get('/menu/{codigoQr}/productos', [MenuQrController::class, 'productos'])
    ->name('menu.productos');

//barra

Route::get('/barra', [BarraController::class, 'index'])
    ->name('barra.index');

Route::patch('/barra/{idFactura}/preparar', [BarraController::class, 'cambiarEstado'])
    ->name('barra.preparar');

Route::patch('/barra/{idFactura}/listo', [BarraController::class, 'cambiarAListo'])
    ->name('barra.listo');

//servicio
Route::get('/servicio', [ServicioController::class, 'index'])
    ->name('servicio.index');

Route::patch('/servicio/{idFactura}/entregar', [ServicioController::class, 'cambiarEstado'])
    ->name('servicio.entregar');