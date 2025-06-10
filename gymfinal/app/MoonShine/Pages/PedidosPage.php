<?php

namespace App\MoonShine\Pages;

use App\Models\Orders;
use MoonShine\Laravel\Pages\Page;
use MoonShine\AssetManager\Raw;
use MoonShine\UI\Components\Alert;


class PedidosPage extends Page
{
    public string $title = 'Pedidos';

    public function components(): array
    {
        /** @var \App\Models\Orders|null $pedido */
        if (request('order_id')) {
            $pedido = Orders::find(request('order_id'));

            if ($pedido) {
                $nuevoEstado = match ($pedido->status) {
                    'pendiente' => 'procesando',
                    'procesando' => 'enviado',
                    'enviado' => 'entregado',
                    default => null,
                };

                if ($nuevoEstado) {
                    $pedido->status = $nuevoEstado;
                    $pedido->save();

                    // Enviar notificaciones según el nuevo estado
                    switch ($nuevoEstado) {
                        case 'procesando':
                            $pedido->notify(new \App\Notifications\PedidoEnProcesoNotification($pedido));
                            session()->flash('message', 'Pedido en procesamiento. El cliente ha sido notificado.');
                            break;

                        case 'enviado':
                            if ($pedido->shipping_method === 'recogida') {
                                $pedido->notify(new \App\Notifications\PedidoParaRecoger($pedido));
                                session()->flash('message', 'El cliente ha sido notificado para recogerlo.');
                            } else {
                                $pedido->notify(new \App\Notifications\PedidoEnviado($pedido));
                                session()->flash('message', 'El cliente ha sido notificado del envío.');
                            }
                            break;

                        case 'entregado':
                            session()->flash('message', 'El pedido ha sido marcado como entregado.');
                            break;
                    }
                } else {
                    session()->flash('message', 'El pedido ya está en entregado.');
                }
            }
        }

        $search = request('search');
        $estado = request('estado');
        $currentPage = request()->get('page', 1);
        $estadosDisponibles = Orders::select('status')->distinct()->pluck('status')->toArray();
        $ordersQuery = Orders::with('items')->orderByDesc('ordered_at');

        // Si hay búsqueda, filtrar
        if ($search) {
            $ordersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('reference', 'like', "%$search%")
                    ->orWhere('dni', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%");
            });
        }
        if ($estado) {
            $ordersQuery->where('status', $estado);
        }

        $orders = $ordersQuery->paginate(8, ['*'], 'page', $currentPage);

        $html = '<style>
            table, th, td { border: 1px solid #4b5563; border-collapse: collapse; padding: 0.5rem; }
            th { background-color: #e5e7eb; color: #111827; font-weight: bold; }
            td { background-color: #f9fafb; color: #111827; }
            .details { margin: 1rem 0; padding: 1rem; background-color: #f3f4f6; border-radius: 0.5rem; color: #111827; }
            .pagination { margin: 1rem 0; display: flex; gap: 0.5rem; justify-content: center; }
            .pagination a, .pagination span { padding: 0.5rem 0.75rem; border-radius: 0.375rem; background: #e5e7eb; color: #111827; text-decoration: none; }
            .pagination .active { background: #374151; color: #fff; }
            .search-form { margin-bottom: 1rem; display: flex; gap: 0.5rem; align-items: center; color: #111827; }
            .search-form input[type="text"], .search-form select { padding: 0.5rem; border-radius: 0.375rem; border: 1px solid #d1d5db; color: #111827; }
            .search-form button { padding: 0.5rem 1rem; border-radius: 0.375rem; background: #e5e7eb; color: #111827; border: none; }
            .ver-detalles-link {
                background:rgba(162, 187, 238, 0.34);
                color: #111827 !important;
                padding: 0.5rem 1rem;
                border-radius: 0.375rem;
                text-decoration: none;
                font-weight: 500;
                box-shadow: 0 2px 8px rgba(16, 185, 129, 0.08);
                transition: background 0.2s, box-shadow 0.2s, color 0.2s;
                display: inline-block;
            }
            .ver-detalles-link:hover {
                background:rgba(162, 187, 238, 0.64);
                color:rgb(26, 31, 175) !important;
                box-shadow: 0 4px 16px rgba(251, 191, 36, 0.15);
            }
            .bg-blue-600, .bg-gray-600 { color: #fff !important; }
        </style>';

        if (session()->has('message')) {
            $html .= '
            <div style="
                background: linear-gradient(90deg, #3b82f6 0%, #6366f1 100%);
                color: #fff;
                padding: 1rem 1.5rem;
                border-radius: 0.5rem;
                margin-bottom: 1.25rem;
                box-shadow: 0 2px 12px rgba(59,130,246,0.12);
                display: flex;
                align-items: center;
                justify-content: space-between;
                font-size: 1rem;
                font-weight: 500;
            ">
                <span style="display: flex; align-items: center;">
                <svg style="width:1.5em;height:1.5em;margin-right:0.75em;fill:none;stroke:white;stroke-width:2;" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="white" stroke-width="2" fill="none"/>
                    <path d="M12 8v4M12 16h.01" stroke="white" stroke-width="2" stroke-linecap="round"/>
                </svg>
                ' . e(session('message')) . '
                </span>
                <button onclick="this.parentElement.style.display=\'none\'" style="
                background: transparent;
                border: none;
                color: #fff;
                font-size: 1.25rem;
                cursor: pointer;
                margin-left: 1rem;
                " title="Cerrar">&times;</button>
            </div>
            ';
        }

        $html .= '<form method="GET" class="search-form">';
        $html .= '<input type="text" name="search" placeholder="Buscar por nombre, email, referencia o DNI" value="' . htmlspecialchars($search ?? '') . '">';
        $html .= '<select name="estado">';
        $html .= '<option value="">Todos los estados</option>';
        foreach ($estadosDisponibles as $estadoOption) {
            $selected = ($estadoOption === $estado) ? 'selected' : '';
            $html .= '<option value="' . htmlspecialchars($estadoOption) . '" ' . $selected . '>' . ucfirst($estadoOption) . '</option>';
        }
        $html .= '</select>';
        $html .= '<button type="submit">Buscar</button>';
        if ($search || $estado) {
            $html .= '<a href="' . url()->current() . '" style="margin-left:0.5rem;background:#111;color:#fff;padding:0.5rem 1rem;border-radius:0.375rem;text-decoration:underline;text-decoration-color:#fff;text-underline-offset:3px;">Limpiar</a>';
        }
        $html .= '</form>';

        $html .= '<h2 class="text-xl font-bold mb-4">Lista de pedidos</h2>';
        $html .= '<table class="w-full mb-6"><thead><tr>
            <th>Referencia</th>
            <th>Nombre</th> 
            <th>DNI</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Total (€)</th>
            <th>Fecha Pedido</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr></thead><tbody>';

        if ($orders->count() === 0) {
            $html .= '<tr><td colspan="9" class="text-center py-4">No se encontraron resultados.</td></tr>';
        } else {
            foreach ($orders as $order) {
                $totalConIva = $order->total_price * 1.21;
                $html .= '<tr>
                    <td>' . $order->reference . '</td>
                    <td>' . $order->name . '</td>
                    <td>' . $order->dni . '</td>
                    <td>' . $order->email . '</td>
                    <td>' . $order->phone . '</td>
                    <td>' . number_format($totalConIva, 2) . '</td>
                    <td>' . optional($order->ordered_at)->addHours(2)->format('d/m/Y H:i') . '</td>
                    <td>
                        <form method="GET" action="' . url()->current() . '">
                            ' . csrf_field() . '
                            <input type="hidden" name="order_id" value="' . $order->id . '">
                            <button type="submit" class="px-3 py-1 rounded" style="background-color: ' . $this->statusColor($order->status) . '; color: #111827;">
                                ' . ucfirst($order->status) . '
                            </button>
                        </form>
                    </td>
                    <td><a href="?pedido=' . $order->id . '" class="ver-detalles-link">Ver detalles</a></td>
                </tr>';
            }
        }

        $html .= '</tbody></table>';

        // paginacion laravel
        if ($orders->lastPage() > 1) {
            $html .= '<div class="pagination">';
            if ($orders->onFirstPage()) {
                $html .= '<span>&laquo;</span>';
            } else {
                $html .= '<a href="' . $orders->appends(['search' => $search])->previousPageUrl() . '">&laquo;</a>';
            }
            for ($i = 1; $i <= $orders->lastPage(); $i++) {
                if ($i == $orders->currentPage()) {
                    $html .= '<span class="active">' . $i . '</span>';
                } else {
                    $html .= '<a href="' . $orders->appends(['search' => $search])->url($i) . '">' . $i . '</a>';
                }
            }
            if ($orders->hasMorePages()) {
                $html .= '<a href="' . $orders->appends(['search' => $search])->nextPageUrl() . '">&raquo;</a>';
            } else {
                $html .= '<span>&raquo;</span>';
            }
            $html .= '</div>';
        }

        // Si hay un pedido seleccionado, mostrar sus detalles
        $pedidoId = request('pedido');
        if ($pedidoId) {
            $pedido = Orders::with('items')->find($pedidoId);

            if ($pedido) {
                $html .= '<div class="details">';
                $html .= '<h3 class="text-lg font-semibold">Detalles del pedido #' . $pedido->id . '</h3>';
                $html .= '<p><strong>Cliente:</strong> ' . $pedido->name . ' (' . $pedido->email . ')</p>';
                $html .= '<p><strong>DNI:</strong> ' . $pedido->dni . '</p>';
                $html .= '<p><strong>Teléfono:</strong> ' . $pedido->phone . '</p>';
                if ($pedido->shipping_method === 'recogida') {
                    $html .= '<p><strong>Entrega:</strong> Recogida en tienda</p>';
                } else {
                    $html .= '<p><strong>Dirección:</strong> ' . $pedido->street . ', ' . $pedido->municipality . ', ' . $pedido->province . '</p>';
                }
                $html .= '<p><strong>Fecha de pedido:</strong> ' . optional($pedido->ordered_at)->addHours(2)->format('d/m/Y H:i') . '</p>';
                $html .= '<p><strong>Estado:</strong> ' . $pedido->status . '</p>';

                $html .= '<h4 class="mt-4 font-bold">Productos:</h4>';
                $html .= '<table class="w-full mt-2"><thead><tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>IVA</th>
                    <th>Total</th>
                </tr></thead><tbody>';

                foreach ($pedido->items as $item) {
                    $subtotalConIva = $item->subtotal * 1.21;
                    $iva = $item->subtotal * 0.21;
                    $html .= '<tr>
                        <td>' . $item->product_name . '</td>
                        <td>' . number_format($item->price, 2) . ' €</td>
                        <td>' . $item->quantity . '</td>
                        <td>' . number_format($item->subtotal, 2) . ' €</td>
                        <td>' . number_format($iva, 2) . ' €</td>
                        <td>' . number_format($subtotalConIva, 2) . ' €</td>
                    </tr>';
                }

                $html .= '</tbody></table>';
                $html .= '<a href="' . url()->current() . '" class="inline-block mt-4" style="background:#111;color:#fff;padding:0.75rem 2rem;border-radius:0.5rem;font-weight:bold;font-size:1.1rem;box-shadow:0 4px 16px rgba(59,130,246,0.18);text-decoration:underline;text-decoration-color:#fff;text-underline-offset:4px;transition:background 0.2s,box-shadow 0.2s;">Volver a pedidos</a>';
                $html .= '</div>';
            }
        }

        return [
            Raw::make($html),
        ];
    }

    private function statusColor(string $status): string
    {
        return match ($status) {
            'pendiente' => '#f59e0b',
            'procesando' => '#3b82f6',
            'enviado' => '#6366f1',
            'entregado' => '#10b981',
            default => '#6b7280',
        };
    }
}
