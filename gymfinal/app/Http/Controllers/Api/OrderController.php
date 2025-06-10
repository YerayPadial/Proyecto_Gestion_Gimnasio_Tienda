<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Orders;
use App\Models\order_items;
use App\Models\Inventario;
use App\Notifications\PedidoRealizadoNotification;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente.nombre' => 'required|string',
            'cliente.telefono' => 'required|string',
            'cliente.email' => 'required|email',
            'cliente.dni' => 'required|string',
            'envioTipo' => 'required|string|in:recogida,envio',
            'envio.direccion' => 'nullable|string',
            'envio.numero' => 'nullable|string',
            'envio.provincia' => 'nullable|string',
            'envio.municipio' => 'nullable|string',
            'envio.pais' => 'nullable|string',
            'envio.codigoPostal' => 'nullable|string',
            'productos' => 'required|array',
            'productos.*.id' => 'required|integer|exists:inventarios,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Calcular el total
            $total = 0;
            foreach ($validated['productos'] as $producto) {
                $productoDB = Inventario::find($producto['id']);
                $subtotal = $productoDB->precio * $producto['cantidad'];
                $total += $subtotal;
            }

            // Crear pedido
            $order = Orders::create([
                'reference'        => Str::uuid(),
                'name'             => $validated['cliente']['nombre'],
                'phone'            => $validated['cliente']['telefono'],
                'email'            => $validated['cliente']['email'],
                'dni'              => $validated['cliente']['dni'],
                'shipping_method'  => $validated['envioTipo'],
                'street'           => $validated['envio']['direccion'] ?? null,
                'street_number'    => $validated['envio']['numero'] ?? null,
                'province'         => $validated['envio']['provincia'] ?? null,
                'municipality'     => $validated['envio']['municipio'] ?? null,
                'country'          => $validated['envio']['pais'] ?? null,
                'postal_code'      => $validated['envio']['codigoPostal'] ?? null,
                'total_price'      => $total,
                'ordered_at'       => now(),
                'status'           => 'pendiente',
            ]);
            // Crear items del pedido
            foreach ($validated['productos'] as $producto) {
                $productoDB = Inventario::find($producto['id']);

                if (!$productoDB) {
                    throw new \Exception("Producto con ID {$producto['id']} no encontrado.");
                }
                if ($productoDB->existencias < $producto['cantidad']) {
                    throw new \Exception("No hay suficiente stock del producto: " . $productoDB->nombre);
                }

                // Descontar stock
                $productoDB->existencias -= $producto['cantidad'];
                $productoDB->save();

                // Registrar item del pedido
                order_items::create([
                    'order_id'     => $order->id,
                    'product_id'   => $producto['id'],
                    'product_name' => $productoDB->nombre,
                    'price'        => $productoDB->precio,
                    'quantity'     => $producto['cantidad'],
                    'subtotal'     => $productoDB->precio * $producto['cantidad'],
                ]);
            }

            $order->load('items');
            $order->notify(new PedidoRealizadoNotification($order));
            DB::commit();

            return response()->json([
                'message' => 'Pedido creado correctamente',
                'order_id' => $order->id,
                'reference' => $order->reference
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al registrar el pedido',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
