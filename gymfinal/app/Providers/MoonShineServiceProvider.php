<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRoleResource;
use App\MoonShine\Resources\MachineResource;
use App\MoonShine\Resources\CuotasResource;
use App\MoonShine\Resources\ClientesResource;
use App\MoonShine\Resources\CategoriasResource;
use App\MoonShine\Resources\InventarioResource;
use App\MoonShine\Pages\IngresosMensualesPage;
use App\MoonShine\Resources\OrdersResource;
use App\MoonShine\Resources\Order_itemsResource;
use App\MoonShine\Pages\PedidosPage;
use App\MoonShine\Pages\IngresosMesTienda;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  MoonShine  $core
     * @param  MoonShineConfigurator  $config
     *
     */
    public function boot(CoreContract $core, ConfiguratorContract $config): void
    {
        // $config->authEnable();

        $core
            ->resources([
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
                MachineResource::class,
                CuotasResource::class,
                ClientesResource::class,
                CategoriasResource::class,
                InventarioResource::class,
                OrdersResource::class,
                Order_itemsResource::class,
            ])
            ->pages([
                ...$config->getPages(),
                IngresosMensualesPage::class,
                PedidosPage::class,
                IngresosMesTienda::class,
            ])
        ;
    }
    
}
