<?php

use App\Http\Controllers\Api\InventarioController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api.key'])->group(function () {
    Route::get('/productos', [InventarioController::class, 'index']);

    Route::put('/productos/{id}', [InventarioController::class, 'update']);

    Route::post('/verificar-usuario', [AuthController::class, 'verificarUsuario']);

    Route::get('/productos/{id}', [InventarioController::class, 'show']);

    Route::post('/orders', [OrderController::class, 'store']);

    Route::post('/enviar-codigo', [AuthController::class, 'enviarCodigo']);

    Route::post('/verificar-codigo', [AuthController::class, 'verificarCodigo']);
});
