<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Calificacion;
use App\Http\Requests\ProductoRequest;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::with('categorias.categoria')->paginate(50);
        return response()->json($productos, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ProductoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductoRequest $request)
    {
        $producto = Producto::create($request->all());
        return response()->json($producto, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto = Producto::with('categorias.categoria')->find($id);
        return response()->json($producto, 200);
    }

    /**
     * Show the form for change the stock var the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function stock($id)
    {
        $producto = Producto::find($id);
        $producto->estado = !$producto->estado;
        $producto->save();
        return response()->json($producto, 200);
    }

    /**
     * Show the form for change the stock var the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function calificar($id, Request $request)
    {
        $producto = Producto::find($id);
        $calificacion = Calificacion::create(['producto_id' => $id, 'calificacion' => $request->calificacion]);
        return response()->json($producto, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ProductoRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductoRequest $request, $id)
    {
        $producto = Producto::find($id);
        $producto = $producto->fill($request->all());
        $producto->save();
        return response()->json($producto, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);
        $producto->categorias()->forceDelete();
        $producto->calificaciones()->forceDelete();
        $producto->forceDelete();
        return response()->json($producto, 200);
    }
}
