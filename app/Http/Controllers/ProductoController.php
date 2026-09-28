<?php

namespace App\Http\Controllers;

use App\Models\producto;
use App\Services\CategoriaService;
use App\Services\ProductoService;
use Illuminate\Http\Request;

class ProductoController extends Controller
{

    private ProductoService $productoService;
    private CategoriaService $categoriaService;

    public function __construct(ProductoService $productoService , CategoriaService $categoriaService) {

        $this->productoService = $productoService;
        $this->categoriaService = $categoriaService;

    }
    
    public function index()
    {
        $productos = $this->productoService->listarProductos();
        return view('Productos.Index',compact('productos'));
    }


    public function create()
    {
        $categoria = $this->categoriaService->listar();
        return view('Productos.Create',compact('categoria'));
    }

    public function store(Request $request)
    {
        $datos['imagen'] = $request->file('imagen');

        $this->productoService->guardarProducto($request->all());

        return redirect()->route('producto.index');
    }


    public function show()
    {
        
    }



    public function edit(int $id)
    {
        
        $categoria = $this->categoriaService->listar();
        $productos = $this->productoService->buscarIdProducto($id);

        return view('Productos.Edit', compact('productos','categoria')) ;
    }

    
    public function update(int $id, Request $request)
    {
        $datos = $request->all();
        $datos['imagen'] = $request->file('imagen'); // puede ser null

        $this->productoService->actualizarProducto($id,$request->all());

        return redirect()->route('producto.index');
    }

    public function cambiarEstadoProducto(int $id){
        $mensaje = $this->productoService->cambiarEstadoProducto($id);
        return redirect()->route('producto.index')->with('success', $mensaje); 
    }


    public function destroy(int $id)
    {
        $this->productoService->eliminarProducto($id);

        return redirect()->route('producto.index');
    }
}
