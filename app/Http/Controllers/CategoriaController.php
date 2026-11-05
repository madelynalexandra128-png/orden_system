<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaStoreRequest;
use App\Http\Requests\CategoriaUpdateRequest;
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
        $contar=$this->categoriaService->contarActivo();
        return view('Categorias.Index',compact('categorias','contar'));
    }

    
    public function create() #manda a la ruta crear 
    {
        return view('Categorias.Create');
    }

    public function store(CategoriaStoreRequest $request)
    {
        $this->categoriaService->guardar($request->validated());

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

    
    public function update(int $id,CategoriaUpdateRequest $request)
    {
        $this->categoriaService->actualizar($id,$request->validated());
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
