<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categorias;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Categorias>
 */
class CategoriasResource extends ModelResource
{
    protected string $model = Categorias::class;

    protected string $title = 'Categorias';
    protected bool $createInModal = false;
    protected bool $detailInModal = true;
    protected bool $editInModal = false;
    protected bool $simplePaginate = true;
    protected int $itemsPerPage = 8;

    protected bool $isAsync = false;
    protected bool $errorsAbove = false;


    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            Text::make('Tipo')->sortable(),
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
            Text::make('Descripcion'),
        ];
    }

    protected function search(): array
    {
        return [
            'tipo',
            'descripcion',
        ];
    }

    /**
     * @param Categorias $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'tipo' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
        ];
    }
}
