<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Clientes;
use App\Observers\ClientesObserver;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrar el observer para el modelo Clientes
        Clientes::observe(ClientesObserver::class);

        
        $this->registerApiRoutes();
    }

    /**
     * Registrar las rutas  API.
     */
    protected function registerApiRoutes(): void
    {
        Route::prefix('api') 
            ->middleware('api') 
            ->group(base_path('routes/api.php')); 
    }
}
