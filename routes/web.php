<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

//categoria
Route::resource('categoria',CategoriaController::class);
Route::post('/categoria/cambiarEstado/{id}',[CategoriaController::class, 'cambiar'])->name('categoria.canbiarEstado');

//producto
Route::resource('/producto',ProductoController::class);