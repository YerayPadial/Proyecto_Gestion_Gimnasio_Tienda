<?php

namespace App\Observers;

use App\Models\Clientes;
use Illuminate\Support\Carbon;

class ClientesObserver
{
    /**
     * Handle the Clientes "created" event.
     */
    public function created(Clientes $clientes): void
    {
        //
    }

    /**
     * Handle the Clientes "updated" event.
     */
    public function updated(Clientes $clientes): void
    {
        //
    }

    /**
     * Handle the Clientes "deleted" event.
     */
    public function deleted(Clientes $clientes): void
    {
        //
    }

    /**
     * Handle the Clientes "restored" event.
     */
    public function restored(Clientes $clientes): void
    {
        //
    }

    /**
     * Handle the Clientes "force deleted" event.
     */
    public function forceDeleted(Clientes $clientes): void
    {
        //
    }

    /**
     * Handle the "saving" event for the Clientes model.
     */
    public function saving(Clientes $cliente): void
    {
        // Verificar si la fecha de caducidad ya ha pasado
        if (Carbon::parse($cliente->fecha_caducidad)->isPast()) {
            // Cambiar la cuota al ID 3 si está caducado
            $cliente->tipo_cuota = 3;
        }
    }

    /*
Por si necesito cmprobar que cambia automaticamente

      INSERT INTO clientes (nombre, apellidos, telefono, dni, fecha_inicio, fecha_caducidad, tipo_cuota, created_at, updated_at)
VALUES ('Cliente Caducado', 'Apellido Caducado', '600030', 'DNI00030', CURDATE() - INTERVAL 30 DAY, CURDATE() - INTERVAL 5 DAY, 2, NOW(), NOW());
     */
}
