<?php

namespace App\Http\Controllers;

use App\Models\categoria;
use App\Services\CategoriaService;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    private CategoriaService $categoria_service;

    public function __construct(CategoriaService $categoriaService) {
        $this->categoria_service = $categoriaService;
    }
    
    public function index()
    {
        //
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
