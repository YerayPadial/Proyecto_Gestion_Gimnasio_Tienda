<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();    // Código de referencia del pedido

            // Datos del cliente
            $table->string('email');                  // Email del comprador
            $table->string('dni');                    // DNI
            $table->string('phone');                  // Teléfono

            // Dirección de envío
            $table->string('country');                // País
            $table->string('province');               // Provincia
            $table->string('municipality');           // Municipio
            $table->string('postal_code');            // Código Postal
            $table->string('street');                 // Calle
            $table->string('street_number');          // Número de calle (como string por si hay letra, ej: 12B)

            // Pedido
            $table->decimal('total_price', 10, 2);    // Total del pedido
            $table->timestamp('ordered_at')->nullable(); // Fecha del pedido
            $table->timestamp('shipped_at')->nullable(); // Fecha de envío

            // Estado y método de envío
            $table->enum('status', [
                'pendiente',
                'procesando',
                'enviado',
                'entregado',
                'cancelado'
            ])->default('pendiente');
            $table->string('shipping_method')->nullable(); // Método de envío

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
