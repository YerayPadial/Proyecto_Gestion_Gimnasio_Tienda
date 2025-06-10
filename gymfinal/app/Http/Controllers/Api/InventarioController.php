<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index(): JsonResponse
    {
        $productos = Inventario::with('categoria')->get();

        return response()->json($productos);
    }

    public function update(Request $request, $id)
    {
        $producto = Inventario::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Productos no encontrado'], 404);
        }

        $producto->update($request->all());

        return response()->json($producto);
    }

    public function show($id): JsonResponse
    {
        $producto = Inventario::with('categoria')->find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto);
    }
}
