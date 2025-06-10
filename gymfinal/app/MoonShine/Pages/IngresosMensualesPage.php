<?php

namespace App\MoonShine\Pages;

use App\Models\Clientes;
use App\Models\Cuotas;
use Carbon\Carbon;
use Illuminate\Support\Str;
use MoonShine\AssetManager\Raw;
use MoonShine\Laravel\Pages\Page;
use MoonShine\UI\Components\Metrics\Wrapped\ValueMetric;

class IngresosMensualesPage extends Page
{
    public string $title = 'Resumen de ingresos mensuales';

    protected function calcularIngresos(): array
    {
        $cuotasClientes = Clientes::with('cuota')->get();
        $ingresosPorMes = [];

        foreach ($cuotasClientes as $cliente) {
            $fecha = Carbon::parse($cliente->fecha_inicio);

            $mesClave = $fecha->day <= 28
                ? $fecha->format('Y-m')
                : $fecha->addMonth()->format('Y-m');

            if ($cliente->cuota) {
                $ingresosPorMes[$mesClave] = ($ingresosPorMes[$mesClave] ?? 0) + $cliente->cuota->precio;
            }
        }

        ksort($ingresosPorMes);
        return $ingresosPorMes;
    }

    protected function calcularClientesCuotaMes(): array
    {
        $tiposDeCuota = Cuotas::all()->pluck('tipo')->toArray();
        $clientesCuotaMes = [];
        $cuotasCliente = Clientes::with('cuota')->get();

        foreach ($cuotasCliente as $cliente) {
            $fecha = Carbon::parse($cliente->fecha_inicio);
            $mesClave = $fecha->day <= 28
                ? $fecha->format('Y-m')
                : $fecha->addMonth()->format('Y-m');

            $tipoCuota = $cliente->cuota->tipo ?? 'Sin cuota';

            if (!isset($clientesCuotaMes[$mesClave])) {
                $clientesCuotaMes[$mesClave] = array_fill_keys($tiposDeCuota, 0);
            }

            if (isset($clientesCuotaMes[$mesClave][$tipoCuota])) {
                $clientesCuotaMes[$mesClave][$tipoCuota]++;
            }
        }

        ksort($clientesCuotaMes);
        return $clientesCuotaMes;
    }

    protected function metrics(): array
    {
        $ingresosPorMes = $this->calcularIngresos();
        $selectedMonth = request()->input('month') ?? now()->format('Y-m');
        $totalIngresado = $ingresosPorMes[$selectedMonth] ?? 0;

        return [
            ValueMetric::make('Total ingresado en ' . Carbon::parse($selectedMonth)->translatedFormat('F Y'))
                ->value(number_format($totalIngresado, 2) . ' €'),
        ];
    }

    public function components(): array
    {
        $metrics = $this->metrics();
        $ingresosPorMes = $this->calcularIngresos();
        $clientesCuotaMes = $this->calcularClientesCuotaMes();
        $tiposDeCuota = Cuotas::all()->pluck('tipo')->toArray();

        $selectedMonth = request('month') ?? now()->format('Y-m');
        $mesesDisponibles = array_keys($ingresosPorMes);

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
                background-color:rgb(21, 72, 182) !important;
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

        $html = '';
        if (!$selectedMonth || isset($ingresosPorMes[$selectedMonth])) {
            $html .= '
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
            </style>
            <br>
            <div class="card">
                <div class="card-body">
                    <h2 class="text-xl font-bold text-gray-200 mb-4">Ingresos detallado</h2>
                    <table class="table-auto w-full text-left border mt-4 text-gray-300">
                        <thead>
                            <tr class="bg-gray-700">
                                <th>Mes</th>
                                <th>Total ingresado (€)</th>';
            foreach ($tiposDeCuota as $tipoCuota) {
                $html .= "<th>{$tipoCuota}</th>";
            }
            $html .= '
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($ingresosPorMes as $mes => $total) {
                if ($selectedMonth && $mes !== $selectedMonth) continue;

                $mesTrans = Str::ucfirst(Carbon::parse($mes)->translatedFormat('F Y'));
                $html .= "<tr>
                            <td>{$mesTrans}</td>
                            <td>" . number_format($total, 2) . " €</td>";

                foreach ($tiposDeCuota as $tipoCuota) {
                    $cantidadClientes = $clientesCuotaMes[$mes][$tipoCuota] ?? 0;
                    $html .= "<td>{$cantidadClientes}</td>";
                }
                $html .= '</tr>';
            }

            $html .= '
                        </tbody>
                    </table>
                </div>
            </div>';
        } else {
            $mesTrans = Str::ucfirst(Carbon::parse($selectedMonth)->translatedFormat('F Y'));
            $html .= '
            <br>
            <div class="card">
                <div class="card-body text-center text-red-500 text-lg font-semibold">
                    No hay ingresos registrados para el mes de ' . $mesTrans . '.
                </div>
            </div>';
        }

        $ingresosAnioActual = [];
        foreach ($ingresosPorMes as $mes => $total) {
            if (Carbon::parse($mes)->year == now()->year) {
                $mesNum = (int)Carbon::parse($mes)->format('m');
                $ingresosAnioActual[$mesNum] = $total;
            }
        }
        $labels = [];
        $values = [];
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->translatedFormat('F');
            $values[] = isset($ingresosAnioActual[$i]) ? (float)$ingresosAnioActual[$i] : 0;
        }
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

        // Devuelve primero el form, luego el metric, luego el resto
        return [
            Raw::make($formHtml),
            ...$metrics,
            Raw::make($html)
        ];
    }
}
