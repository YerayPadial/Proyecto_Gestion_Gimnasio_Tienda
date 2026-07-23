<?php

namespace Database\Seeders;

use App\Models\Categorias;
use App\Models\Clientes;
use App\Models\Cuotas;
use App\Models\Inventario;
use App\Models\Machine;
use App\Models\Orders;
use App\Models\order_items;
use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'password' => Hash::make('password'),
        ]);

        $mensual = Cuotas::updateOrCreate(
            ['tipo' => 'Mensual'],
            ['precio' => 39.90, 'descripcion' => 'Acceso completo al gimnasio durante un mes.']
        );

        $trimestral = Cuotas::updateOrCreate(
            ['tipo' => 'Trimestral'],
            ['precio' => 99.90, 'descripcion' => 'Plan trimestral con acceso completo y seguimiento.']
        );

        $anual = Cuotas::updateOrCreate(
            ['tipo' => 'Anual'],
            ['precio' => 349.90, 'descripcion' => 'Membresia anual con precio reducido y revision inicial incluida.']
        );

        $ropa = Categorias::updateOrCreate(
            ['tipo' => 'Ropa deportiva'],
            ['descripcion' => 'Prendas para entrenar con comodidad.']
        );

        $suplementos = Categorias::updateOrCreate(
            ['tipo' => 'Suplementos'],
            ['descripcion' => 'Productos de apoyo para el entrenamiento.']
        );

        $accesorios = Categorias::updateOrCreate(
            ['tipo' => 'Accesorios'],
            ['descripcion' => 'Complementos para mejorar cada sesión de entrenamiento.']
        );

        $products = [
            [
                'nombre' => 'Camiseta FinalGym',
                'tipo_categoria' => $ropa->id,
                'precio' => 19.90,
                'existencias' => 18,
                'descripcion' => 'Camiseta tecnica transpirable para entrenamiento.',
                'foto' => 'products/finalgym-camiseta.svg',
            ],
            [
                'nombre' => 'Shaker deportivo',
                'tipo_categoria' => $suplementos->id,
                'precio' => 8.50,
                'existencias' => 25,
                'descripcion' => 'Botella mezcladora para batidos y bebidas isotonicas.',
                'foto' => 'products/finalgym-shaker.svg',
            ],
            [
                'nombre' => 'Guantes de entrenamiento',
                'tipo_categoria' => $ropa->id,
                'precio' => 14.90,
                'existencias' => 10,
                'descripcion' => 'Guantes con agarre para ejercicios de fuerza.',
                'foto' => 'products/finalgym-guantes.svg',
            ],
            [
                'nombre' => 'Toalla premium FinalGym',
                'tipo_categoria' => $accesorios->id,
                'precio' => 12.90,
                'existencias' => 20,
                'descripcion' => 'Toalla compacta de microfibra para sala y vestuario.',
                'foto' => 'products/finalgym-toalla.svg',
            ],
            [
                'nombre' => 'Proteina Whey Pro',
                'tipo_categoria' => $suplementos->id,
                'precio' => 34.90,
                'existencias' => 12,
                'descripcion' => 'Proteina sabor vainilla para recuperacion muscular.',
                'foto' => 'products/finalgym-proteina.svg',
            ],
            [
                'nombre' => 'Banda elastica resistencia',
                'tipo_categoria' => $accesorios->id,
                'precio' => 9.90,
                'existencias' => 30,
                'descripcion' => 'Banda de resistencia media para movilidad y fuerza.',
                'foto' => 'products/finalgym-banda.svg',
            ],
        ];

        foreach ($products as $product) {
            Inventario::updateOrCreate(
                ['nombre' => $product['nombre']],
                $product
            );
        }

        Clientes::updateOrCreate(
            ['dni' => '12345678A'],
            [
                'nombre' => 'Cliente',
                'apellidos' => 'Demo',
                'email' => 'cliente@example.com',
                'telefono' => '600000000',
                'fecha_inicio' => now()->toDateString(),
                'fecha_caducidad' => now()->addMonth()->toDateString(),
                'tipo_cuota' => $mensual->id,
                'foto' => null,
            ]
        );

        $clientes = [
            [
                'dni' => '23456789B',
                'nombre' => 'Lucia',
                'apellidos' => 'Martin Ruiz',
                'email' => 'lucia.martin@example.com',
                'telefono' => '611222333',
                'fecha_inicio' => now()->subDays(12),
                'fecha_caducidad' => now()->addDays(18),
                'tipo_cuota' => $mensual->id,
            ],
            [
                'dni' => '34567890C',
                'nombre' => 'Mario',
                'apellidos' => 'Santos Perez',
                'email' => 'mario.santos@example.com',
                'telefono' => '622333444',
                'fecha_inicio' => now()->subMonth()->startOfMonth()->addDays(6),
                'fecha_caducidad' => now()->addMonths(2)->startOfMonth()->addDays(6),
                'tipo_cuota' => $trimestral->id,
            ],
            [
                'dni' => '45678901D',
                'nombre' => 'Nerea',
                'apellidos' => 'Lopez Cano',
                'email' => 'nerea.lopez@example.com',
                'telefono' => '633444555',
                'fecha_inicio' => now()->subMonths(2)->startOfMonth()->addDays(11),
                'fecha_caducidad' => now()->addMonths(10)->startOfMonth()->addDays(11),
                'tipo_cuota' => $anual->id,
            ],
            [
                'dni' => '56789012E',
                'nombre' => 'Diego',
                'apellidos' => 'Navarro Gil',
                'email' => 'diego.navarro@example.com',
                'telefono' => '644555666',
                'fecha_inicio' => now()->startOfMonth()->addDays(2),
                'fecha_caducidad' => now()->addMonth()->startOfMonth()->addDays(2),
                'tipo_cuota' => $mensual->id,
            ],
        ];

        foreach ($clientes as $cliente) {
            Clientes::updateOrCreate(
                ['dni' => $cliente['dni']],
                [
                    ...$cliente,
                    'fecha_inicio' => $cliente['fecha_inicio']->toDateString(),
                    'fecha_caducidad' => $cliente['fecha_caducidad']->toDateString(),
                    'foto' => null,
                ]
            );
        }

        $demoOrders = [
            [
                'reference' => 'FG-DEMO-' . now()->format('Ym') . '-001',
                'name' => 'Lucia Martin Ruiz',
                'email' => 'lucia.martin@example.com',
                'dni' => '23456789B',
                'phone' => '611222333',
                'ordered_at' => now()->subDays(3)->setTime(18, 35),
                'status' => 'entregado',
                'shipping_method' => 'recogida',
                'items' => [
                    ['nombre' => 'Camiseta FinalGym', 'quantity' => 1],
                    ['nombre' => 'Shaker deportivo', 'quantity' => 1],
                ],
            ],
            [
                'reference' => 'FG-DEMO-' . now()->format('Ym') . '-002',
                'name' => 'Mario Santos Perez',
                'email' => 'mario.santos@example.com',
                'dni' => '34567890C',
                'phone' => '622333444',
                'ordered_at' => now()->subDays(9)->setTime(11, 20),
                'status' => 'procesando',
                'shipping_method' => 'envio',
                'street' => 'Avenida del Deporte',
                'street_number' => '24',
                'municipality' => 'Granada',
                'province' => 'Granada',
                'country' => 'Espana',
                'postal_code' => '18006',
                'items' => [
                    ['nombre' => 'Proteina Whey Pro', 'quantity' => 1],
                    ['nombre' => 'Banda elastica resistencia', 'quantity' => 2],
                ],
            ],
            [
                'reference' => 'FG-DEMO-' . now()->subMonth()->format('Ym') . '-001',
                'name' => 'Nerea Lopez Cano',
                'email' => 'nerea.lopez@example.com',
                'dni' => '45678901D',
                'phone' => '633444555',
                'ordered_at' => now()->subMonth()->startOfMonth()->addDays(14)->setTime(17, 10),
                'status' => 'enviado',
                'shipping_method' => 'envio',
                'street' => 'Calle Energia',
                'street_number' => '8',
                'municipality' => 'Jaen',
                'province' => 'Jaen',
                'country' => 'Espana',
                'postal_code' => '23004',
                'items' => [
                    ['nombre' => 'Guantes de entrenamiento', 'quantity' => 1],
                    ['nombre' => 'Toalla premium FinalGym', 'quantity' => 2],
                ],
            ],
        ];

        foreach ($demoOrders as $demoOrder) {
            $items = collect($demoOrder['items'])->map(function (array $item) {
                $product = Inventario::where('nombre', $item['nombre'])->firstOrFail();

                return [
                    'product_id' => $product->id,
                    'product_name' => $product->nombre,
                    'price' => $product->precio,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->precio * $item['quantity'],
                ];
            });

            $order = Orders::updateOrCreate(
                ['reference' => $demoOrder['reference']],
                [
                    'name' => $demoOrder['name'],
                    'email' => $demoOrder['email'],
                    'dni' => $demoOrder['dni'],
                    'phone' => $demoOrder['phone'],
                    'country' => $demoOrder['country'] ?? null,
                    'province' => $demoOrder['province'] ?? null,
                    'municipality' => $demoOrder['municipality'] ?? null,
                    'postal_code' => $demoOrder['postal_code'] ?? null,
                    'street' => $demoOrder['street'] ?? null,
                    'street_number' => $demoOrder['street_number'] ?? null,
                    'total_price' => $items->sum('subtotal'),
                    'ordered_at' => Carbon::parse($demoOrder['ordered_at']),
                    'shipped_at' => $demoOrder['status'] === 'enviado'
                        ? Carbon::parse($demoOrder['ordered_at'])->addDays(1)
                        : null,
                    'status' => $demoOrder['status'],
                    'shipping_method' => $demoOrder['shipping_method'],
                ]
            );

            order_items::where('order_id', $order->id)->delete();

            foreach ($items as $item) {
                order_items::create([
                    ...$item,
                    'order_id' => $order->id,
                ]);
            }
        }

        Machine::updateOrCreate(
            ['title' => 'Zona de fuerza'],
            ['content' => 'Rack, press banca y mancuernas para entrenamientos completos.']
        );
    }
}
