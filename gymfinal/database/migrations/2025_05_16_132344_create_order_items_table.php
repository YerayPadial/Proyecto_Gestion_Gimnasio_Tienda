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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Relación con pedidos

            $table->foreignId('product_id')->nullable()->constrained('inventarios')->nullOnDelete(); // Relación con productos (opcional)
            $table->string('product_name');         // Nombre del producto (guardado por si cambia luego)
            $table->decimal('price', 10, 2);        // Precio por unidad en ese momento
            $table->integer('quantity');            // Cantidad
            $table->decimal('subtotal', 10, 2);     // price * quantity

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
