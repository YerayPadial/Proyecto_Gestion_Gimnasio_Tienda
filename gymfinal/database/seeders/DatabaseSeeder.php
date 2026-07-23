<?php

namespace Database\Seeders;

use App\Models\Categorias;
use App\Models\Clientes;
use App\Models\Cuotas;
use App\Models\Inventario;
use App\Models\Machine;
use App\Models\User;
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

        Cuotas::updateOrCreate(
            ['tipo' => 'Trimestral'],
            ['precio' => 99.90, 'descripcion' => 'Plan trimestral con acceso completo y seguimiento.']
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

        Machine::updateOrCreate(
            ['title' => 'Zona de fuerza'],
            ['content' => 'Rack, press banca y mancuernas para entrenamientos completos.']
        );
    }
}
