<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cuotas;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Cuotas>
 */
class CuotasResource extends ModelResource
{
    protected string $model = Cuotas::class;

    protected string $title = 'Cuotas';
    protected bool $createInModal = false;
    protected bool $detailInModal = true;
    protected bool $editInModal = false;

    protected bool $isAsync = false;
    protected bool $errorsAbove = false;
    protected bool $simplePaginate = true;
    protected int $itemsPerPage = 8;

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            Text::make('Tipo')->sortable(),
            Text::make('Precio')->sortable(),
            Text::make('Descripcion')->sortable(),

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
                Text::make('Tipo'),
                Text::make('Precio'),
                Text::make('Descripcion'),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            Text::make('Tipo'),
            Text::make('Precio'),
            Text::make('Descripcion'),
        ];
    }

    protected function search(): array
    {
        return [
            'tipo',
            'precio',
            'descripcion',
        ];
    }

    /**
     * @param Cuotas $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'tipo' => ['required', 'string', 'max:255'], // Validar que el tipo sea una cadena de texto
            'precio' => ['required', 'numeric'], // Validar que el precio sea numérico
            'descripcion' => ['required', 'string'], // Validar que la descripción sea una cadena de texto
        ];
    }

    /**
     * Mensajes de error personalizados para las validaciones.
     *
     * @return array<string, string>
     */
    public function validationMessages(): array
    {
        return [
            'tipo.required' => 'El tipo es obligatorio.',
            'tipo.string' => 'El tipo debe ser una cadena de texto.',
            'tipo.max' => 'El tipo no puede tener más de 255 caracteres.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un valor numérico.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
        ];
    }
}
