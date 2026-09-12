<?php

namespace App\Http\Controllers;

use App\Models\producto;
use App\Services\ProductoService;
use Illuminate\Http\Request;

class ProductoController extends Controller
{

    private ProductoService $productoService;

    public function __construct(ProductoService $productoService) {

        $this->productoService = $productoService;

    }
    
    public function index()
    {
        $productos = $this->productoService->listarProductos();
        return view('Productos.Index',compact('productos'));
    }


    public function create()
    {
        
    }

    public function store()
    {
        
    }


    public function show()
    {
        
    }



    public function edit()
    {
        
    }

    
    public function update()
    {
        
    }


    public function destroy()
    {
        
    }
}
