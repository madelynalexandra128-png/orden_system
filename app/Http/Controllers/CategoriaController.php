<?php

namespace App\Http\Controllers;

use App\Models\categoria;
use App\Services\CategoriaService;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    private CategoriaService $categoriaservice;

    public function __construct(CategoriaService $categoriaService) {
        $this->categoriaservice = $categoriaService;
    }
    
    public function index()
    {
        $categorias = $this->categoriaservice->listar();
        return view('Categorias.Index',compact('categorias'));
    }

    
    public function create() #manda a la ruta crear 
    {
        return view('Categorias.Create');
    }

    public function store(Request $request)
    {
        $this->categoriaservice->guardar($request->all());

        return redirect()->route('categoria.index')->with('success','categorias creada correctamente');#dirijir a la pegina principal 
    }

    
    public function show()
    {
        
    }

    
    public function edit(int $id)
    {
        $categorias=$this->categoriaservice->buscarId($id);
        return  view('Categorias.Edit',compact('categorias'));
    }

    
    public function update(int $id,Request $request)
    {
        $this->categoriaservice->actualizar($id,$request->all());
        return redirect()->route('categoria.index')->with('success','actualizada  correctamente');#dirijir a la pegina principal 
    }

    public function cambiar(int $id){
        $mensaje = $this->categoriaservice->canbiar($id);
        return redirect()->route('categoria.index')->with('success', $mensaje); 
    }

    
    public function destroy(int $id)
    {
        $this ->categoriaservice->eliminar($id);

        return redirect()->route('categoria.index')->with('success', 'eliminada correctamente');
    }
}
