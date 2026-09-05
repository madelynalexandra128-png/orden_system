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
        $categorias = $this->categoria_service->listar();
        return view('Categorias.Index',compact('categorias'));
    }

    
    public function create() #manda a la ruta crear 
    {
        return view('Categorias.Create');
    }

    public function store(Request $request)
    {
        $this->categoria_service->guardar($request->all());

        return redirect()->route('categoria.index')->with('success','categorias creada correctamente');#dirijir a la pegina principal 
    }

    
    public function show()
    {
        
    }

    
    public function edit(int $id)
    {
        $categorias=$this->categoria_service->buscarId($id);
        return  view('Categorias.Edit',compact('categorias'));
    }

    
    public function update(int $id,Request $request)
    {
        $this->categoria_service->actualizar($id,$request->all());
        return redirect()->route('categoria.index')->with('success','actualizada  correctamente');#dirijir a la pegina principal 
    }

    
    public function destroy()
    {
        
    }
}
