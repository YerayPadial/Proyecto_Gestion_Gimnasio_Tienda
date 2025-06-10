<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MoonShine\Laravel\Pages\Page;
use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use MoonShine\AssetManager\Raw;
use MoonShine\UI\Components\Metrics\Wrapped\ValueMetric;

class IngresosMesTienda extends Page
{
    public string $title = 'Ingresos mensuales tienda';

    public function components(): array
    {
        $selectedMonth = request()->input('month') ?? now()->format('Y-m');
        $startOfMonth = Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth();
        $endOfMonth = Carbon::createFromFormat('Y-m', $selectedMonth)->endOfMonth();

        // Obtener pedidos del mes seleccionado
        $pedidosCollection = Orders::query()
            ->whereBetween('ordered_at', [$startOfMonth, $endOfMonth])
            ->orderBy('ordered_at')
            ->get();

        $totalIngresado = $pedidosCollection->sum('total_price');

        // Paginación
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 8;
        $currentItems = $pedidosCollection->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $pedidos = new LengthAwarePaginator($currentItems, $pedidosCollection->count(), $perPage, $currentPage, [
            'path' => Request::url(),
            'query' => Request::query(),
        ]);

        // Ingresos por mes del año actual
        $ingresosPorMes = Orders::query()
            ->selectRaw('MONTH(ordered_at) as mes, SUM(total_price) as total')
            ->whereYear('ordered_at', now()->year)
            ->groupByRaw('MONTH(ordered_at)')
            ->orderByRaw('MONTH(ordered_at)')
            ->get();

        $labels = [];
        $values = [];
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->translatedFormat('F');
            $ingresoMes = $ingresosPorMes->firstWhere('mes', $i);
            $values[] = $ingresoMes ? number_format((float)$ingresoMes->total, 2, '.', '') : 0;
        }

        $metrics = [
            ValueMetric::make('Total ingresado en ' . $startOfMonth->translatedFormat('F Y'))
                ->value(number_format((float)$totalIngresado, 2) . ' €'),
        ];

        // datepicker
        $formHtml = '
        <style>
            input[type="month"] {
                background-color: #374151;
                color: #ffffff;
                border: 1px solid #4b5563;
                padding: 0.5rem;
                border-radius: 0.25rem;
            }
            .btn-blue {
                background-color: rgb(21, 72, 182)!important;
                color: #fff !important;
                border: none;
                padding: 0.5rem 1rem;
                border-radius: 0.25rem;
                transition: background 0.2s;
            }
            .btn-blue:hover {
                background-color: #1d4ed8 !important;
            }
        </style>
        <div class="card mb-6">
            <div class="card-body">
                <form method="GET" action="' . url()->current() . '">
                    <label for="month" class="block text-gray-300 mb-2">Selecciona un mes:</label>
                    <input type="month" name="month" id="month" value="' . $selectedMonth . '" max="' . now()->format('Y-m') . '" class="mb-4" />
                    <button type="submit" class="btn-blue ml-2">Buscar</button>
                    <a href="' . url()->current() . '" class="btn-blue ml-2">Actual</a>
                </form>
            </div>
        </div>';

        // estilos tabla
        $html = '
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
                font-family: Arial, sans-serif;
            }
            th, td {
                padding: 10px;
                text-align: center;
                border: 1px solid #4b5563;
            }
            th {
                background-color: #374151;
                color: #ffffff;
                font-weight: bold;
            }
            tr:nth-child(odd) {
                background-color: #e5e7eb;
            }
            tr:hover {
                background-color: #d1d5db;
            }
            td {
                color: #111827;
            }
            .pagination {
                display: flex;
                justify-content: center;
                margin-top: 1rem;
            }
            .pagination a {
                color: #ffffff;
                background-color: #374151;
                border: 1px solid #4b5563;
                padding: 0.5rem 1rem;
                margin: 0 0.25rem;
                text-decoration: none;
                border-radius: 0.25rem;
            }
            .pagination a:hover {
                background-color: #4b5563;
            }
            .pagination .active {
                background-color:rgb(25, 67, 158);
                color: white;
                padding: 0.5rem 1rem;
                margin: 0 0.25rem;
                text-decoration: none;
                border-radius: 0.25rem;
            }
        </style>
        ';

        // Tabla o mensaje
        if ($pedidos->isEmpty()) {
            $html .= '
            <br>
            <div class="card">
                <div class="card-body">
                    <p class="text-gray-200 text-lg">No existen pedidos para el mes seleccionado.</p>
                </div>
            </div>';
        } else {
            $html .= '
            <br>
            <div class="card">
                <div class="card-body">
                    <h2 class="text-xl font-bold text-gray-200 mb-4">Pedidos en ' . $startOfMonth->translatedFormat('F Y') . '</h2>
                    <table class="table-auto w-full text-left border mt-4 text-gray-300">
                        <thead>
                            <tr class="bg-gray-700">
                                <th class="p-2 border">ID Pedido</th>
                                <th class="p-2 border">Fecha</th>
                                <th class="p-2 border">Total (€)</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach ($pedidos as $pedido) {
                $html .= '<tr>
                            <td class="p-2 border">' . $pedido->id . '</td>
                            <td class="p-2 border">' . Carbon::parse($pedido->ordered_at)->format('d/m/Y') . '</td>
                            <td class="p-2 border">' . number_format((float)$pedido->total_price, 2) . ' €</td>
                        </tr>';
            }
            $html .= '
                        </tbody>
                    </table>
                    <div class="pagination">' . $pedidos->links('pagination::bootstrap-4') . '</div>
                </div>
            </div>';
        }

        // Gráfico
        if (array_sum($values) > 0) {
            $html .= '
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <br>
            <div class="card mb-6">
                <div class="card-body">
                    <h2 class="text-xl text-black mb-4">Gráfico de ingresos por mes (' . now()->year . ')</h2>
                    <canvas id="ingresosChart" height="100"></canvas>
                </div>
            </div>
            <script>
                const ctx = document.getElementById("ingresosChart").getContext("2d");
                new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: ' . json_encode($labels) . ',
                        datasets: [{
                            label: "Ingresos (€)",
                            data: ' . json_encode($values) . ',
                            backgroundColor: "rgba(59, 130, 246, 0.7)",
                            borderColor: "rgba(37, 99, 235, 1)",
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: "#000000"
                                },
                                grid: {
                                    color: "#4b5563"
                                }
                            },
                            x: {
                                ticks: {
                                    color: "#000000"
                                },
                                grid: {
                                    color: "#4b5563"
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: "#000000"
                                }
                            }
                        }
                    }
                });
            </script>';
        }

        // Devuelve primero el formulario, luego el metric, luego el resto
        return [
            Raw::make($formHtml),
            ...$metrics,
            Raw::make($html),
        ];
    }
}
