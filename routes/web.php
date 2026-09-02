<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::resource('categoria',CategoriaController::class);