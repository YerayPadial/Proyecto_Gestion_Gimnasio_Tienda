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
 * @extends ModelResource<Orders>
 */
class OrdersResource extends ModelResource
{
    protected string $model = Orders::class;

    protected string $title = 'Pedidos';

    protected bool $createInModal = false;
    protected bool $detailInModal = true;
    protected bool $editInModal = false;

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
            Text::make('Referencia', 'reference')->sortable(),
            Text::make('Nombre', 'name')->sortable(),
            Text::make('Email')->sortable(),
            Text::make('DNI')->sortable(),
            Text::make('Teléfono', 'phone')->sortable(),
            Text::make('Estado', 'status')->sortable(),
            Date::make('Fecha Pedido', 'ordered_at')->sortable(),
            Date::make('Fecha Envío', 'shipped_at')->sortable(),
            Number::make('Precio Total', 'total_price')->sortable(),
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

                Flex::make([
                    Text::make('Referencia', 'reference'),
                    Text::make('Nombre', 'name'),
                    Text::make('Email'),
                ]),

                Flex::make([
                    Text::make('DNI'),
                    Text::make('Teléfono', 'phone'),
                ]),

                Flex::make([
                    Number::make('Precio Total', 'total_price'),
                    Select::make('Método Envío', 'shipping_method')
                        ->options([
                            'Recogida en tienda' => 'Recogida en tienda',
                            'Envio' => 'Envio',
                        ]),
                ]),

                Flex::make([
                    Text::make('País', 'country')->showWhen('shipping_method', 'Envio'),
                    Text::make('Provincia', 'province')->showWhen('shipping_method', 'Envio'),
                ]),
                Flex::make([
                    Text::make('Municipio', 'municipality')->showWhen('shipping_method', 'Envio'),
                    Text::make('Código Postal', 'postal_code')->showWhen('shipping_method', 'Envio'),
                ]),
                Flex::make([
                    Text::make('Calle', 'street')->showWhen('shipping_method', 'Envio'),
                    Text::make('Número', 'street_number')->showWhen('shipping_method', 'Envio'),
                ]),


                Flex::make([
                    Select::make('Estado', 'status')
                        ->options([
                            'pendiente' => 'Pendiente',
                            'procesando' => 'Procesando',
                            'enviado' => 'Enviado',
                            'cancelado' => 'Cancelado',
                            'entregado' => 'Entregado',
                        ])->searchable(),
                    Date::make('Fecha Pedido', 'ordered_at'),
                    Date::make('Fecha Envío', 'shipped_at'),
                ]),
            ]),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Referencia', 'reference'),
            Text::make('Nombre', 'name'),
            Text::make('Email'),
            Text::make('DNI'),
            Text::make('Teléfono', 'phone'),
            Text::make('País', 'country'),
            Text::make('Provincia', 'province'),
            Text::make('Municipio', 'municipality'),
            Text::make('Código Postal', 'postal_code'),
            Text::make('Calle', 'street'),
            Text::make('Número', 'street_number'),
            Number::make('Precio Total', 'total_price'),
            Text::make('Método Envío', 'shipping_method'),
            Text::make('Estado', 'status'),
            Date::make('Fecha Pedido', 'ordered_at'),
            Date::make('Fecha Envío', 'shipped_at'),
        ];
    }

    /**
     * @param Orders $item
     *
     * @return array<string, string[]|string>
     */
    protected function rules(mixed $item): array
    {
        $rules = [
            'reference' => ['required'],
            'email' => ['required', 'email'],
            'dni' => ['required', 'regex:/^[0-9]{8}[A-Za-z]$/'],
            'phone' => ['required', 'numeric'],
            'total_price' => ['required', 'numeric'],
            'ordered_at' => ['required', 'date'],
            'shipped_at' => ['nullable', 'date'],
            'status' => ['required'],
            'shipping_method' => ['required'],
        ];

        if (request()->input('shipping_method') === 'Envio') {
            $rules += [
                'country' => ['required'],
                'province' => ['required'],
                'municipality' => ['required'],
                'postal_code' => ['required', 'numeric'],
                'street' => ['required'],
                'street_number' => ['required'],
            ];
        }

        return $rules;
    }

    public function validationMessages(): array
    {
        return [
            'reference.required' => 'La referencia es obligatoria.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Debe ser un email válido.',
            'dni.required' => 'El DNI es obligatorio.',
            'phone.required' => 'El teléfono es obligatorio.',
            'country.required' => 'El país es obligatorio.',
            'province.required' => 'La provincia es obligatoria.',
            'municipality.required' => 'El municipio es obligatorio.',
            'postal_code.required' => 'El código postal es obligatorio.',
            'street.required' => 'La calle es obligatoria.',
            'street_number.required' => 'El número es obligatorio.',
            'total_price.required' => 'El precio total es obligatorio.',
            'total_price.numeric' => 'El precio debe ser numérico.',
            'ordered_at.required' => 'La fecha del pedido es obligatoria.',
            'ordered_at.date' => 'La fecha debe tener formato válido.',
            'shipped_at.date' => 'La fecha de envío debe tener formato válido.',
            'status.required' => 'El estado es obligatorio.',
            'shipping_method.required' => 'El método de envío es obligatorio.',
        ];
    }

    protected function search(): array
    {
        return [
            'reference',
            'email',
            'dni',
            'phone',
            'country',
            'province',
            'municipality',
            'postal_code',
            'status',
        ];
    }
}
