<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Orders;
use App\Models\order_items;
use App\Models\Inventario;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Components\Layout\Flex;
use MoonShine\UI\Fields\Select;

/**
 * @extends ModelResource<Order_items>
 */
class Order_itemsResource extends ModelResource
{
    protected string $model = Order_items::class;

    protected string $title = 'Order_items';
    protected bool $detailInModal = true;
    protected bool $simplePaginate = true;
    protected int $itemsPerPage = 8;

    protected bool $columnSelection = true;

    protected bool $isAsync = false;
    protected bool $errorsAbove = false;

    /**
     * @return list<FieldContract>
     */


    protected function indexFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Nombre del Producto', 'product_name'),
            Number::make('Precio', 'price'),
            Number::make('Cantidad', 'quantity'),
            Number::make('Subtotal', 'subtotal'),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Nombre del Producto', 'product_name'),
            Number::make('Precio', 'price'),
            Number::make('Cantidad', 'quantity'),
            Number::make('Subtotal', 'subtotal'),
        ];
    }

    /**
     * @param Order_items $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
