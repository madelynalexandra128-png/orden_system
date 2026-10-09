<?php

namespace App\Http\Controllers;

use App\Models\categoria;
use App\Services\CategoriaService;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    private CategoriaService $categoriaService;

    public function __construct(CategoriaService $categoriaService) {
        $this->categoriaService = $categoriaService;
    }
    
    public function index()
    {
        $categorias = $this->categoriaService->listar();
        return view('Categorias.Index',compact('categorias'));
    }

    
    public function create() #manda a la ruta crear 
    {
        return view('Categorias.Create');
    }

    public function store(Request $request)
    {
        $this->categoriaService->guardar($request->all());

        return redirect()->route('categoria.index')->with('success','categorias creada correctamente');#dirijir a la pegina principal 
    }

    
    public function show()
    {
        
    }

    
    public function edit(int $id)
    {
        $categorias=$this->categoriaService->buscarId($id);
        return  view('Categorias.Edit',compact('categorias'));
    }

    
    public function update(int $id,Request $request)
    {
        $this->categoriaService->actualizar($id,$request->all());
        return redirect()->route('categoria.index')->with('success','actualizada  correctamente');#dirijir a la pegina principal 
    }

    public function cambiar(int $id){
        $mensaje = $this->categoriaService->canbiar($id);
        return redirect()->route('categoria.index')->with('success', $mensaje); 
    }

    
    public function destroy(int $id)
    {
        $this ->categoriaService->eliminar($id);

        return redirect()->route('categoria.index')->with('success', 'eliminada correctamente');
    }
}
