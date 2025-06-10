<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Laravel\Components\Layout\{Locales, Notifications, Profile, Search};
use MoonShine\UI\Components\{
    Breadcrumbs,
    Components,
    Layout\Flash,
    Layout\Div,
    Layout\Body,
    Layout\Burger,
    Layout\Content,
    Layout\Footer,
    Layout\Head,
    Layout\Favicon,
    Layout\Assets,
    Layout\Meta,
    Layout\Header,
    Layout\Html,
    Layout\Layout,
    Layout\Logo,
    Layout\Menu,
    Layout\Sidebar,
    Layout\ThemeSwitcher,
    Layout\TopBar,
    Layout\Wrapper,
    When
};
use App\MoonShine\Resources\MachineResource;
use App\MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRoleResource;
use MoonShine\MenuManager\MenuItem;
use App\MoonShine\Resources\CuotasResource;
use App\MoonShine\Resources\ClientesResource;
use MoonShine\MenuManager\MenuGroup;
use App\MoonShine\Resources\CategoriasResource;
use App\MoonShine\Resources\InventarioResource;
use App\MoonShine\Pages\IngresosMensualesPage;
use App\MoonShine\Pages\IngresosMesTienda;
use App\MoonShine\Pages\PedidosPage;
use App\MoonShine\Resources\OrdersResource;
use App\MoonShine\Resources\Order_itemsResource;

final class MoonShineLayout extends AppLayout
{
    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        return [
            MenuGroup::make(static fn() => __('Sistema'), [
                MenuItem::make(
                    static fn() => __('Administradores'),
                    MoonShineUserResource::class
                )->icon('users'),
                MenuItem::make(
                    static fn() => __('Roles'),
                    MoonShineUserRoleResource::class
                )->icon('bookmark'),
            ])->icon('adjustments-vertical'),
            MenuGroup::make(static fn() => __('Gimnasio'), [
                MenuItem::make('Cuotas', CuotasResource::class)->icon('identification'),
                MenuItem::make('Clientes', ClientesResource::class)->icon('user-plus'),
            ])->icon('briefcase'),
            MenuGroup::make(static fn() => __('Almacen'), [
                MenuItem::make(
                    static fn() => __('Categoria'),
                    CategoriasResource::class
                )->icon('queue-list'),
                MenuItem::make(
                    static fn() => __('Inventario'),
                    InventarioResource::class
                )->icon('clipboard-document-check'),
            ])->icon('shopping-cart'),
            MenuGroup::make(static fn() => __('Ingresos'), [
                MenuItem::make('Ingresos membresía', IngresosMensualesPage::class)
                    ->icon('currency-euro'),
                MenuItem::make('Ingresos tienda', IngresosMesTienda::class)
                    ->icon('building-storefront'),
            ])->icon('chart-bar'),
            MenuItem::make('Pedidos', PedidosPage::class)
                ->icon('truck'),
        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        $colorManager->secondary('rgb(20,62,115)');
        $colorManager->primary('rgb(20,62,115)');
    }

    protected function getFooterCopyright(): string
    {
        return 'Team FinalGym';
    }

    protected function getFooterComponent(): Footer
    {
        return parent::getFooterComponent()->menu([]);
    }

    public function build(): Layout
    {
        return parent::build();
    }
}
