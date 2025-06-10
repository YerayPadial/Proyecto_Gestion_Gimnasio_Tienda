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
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_categoria');
            $table->string('nombre', 100);
            $table->decimal('precio', 8, 2);
            $table->integer('existencias');
            $table->text('descripcion')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();


            $table->foreign('tipo_categoria')->references('id')->on('categorias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
