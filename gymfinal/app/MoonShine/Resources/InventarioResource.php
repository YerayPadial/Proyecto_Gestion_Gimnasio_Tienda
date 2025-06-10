<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inventario;
use App\Models\Categorias;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Components\Layout\Flex;
use MoonShine\UI\Fields\Select;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\ImportExport\Contracts\HasImportExportContract;
use MoonShine\ImportExport\Traits\ImportExportConcern;
use MoonShine\ImportExport\ImportHandler;
use MoonShine\ImportExport\ExportHandler;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Fields\Image;

/**
 * @extends ModelResource<Inventario>
 */
class InventarioResource extends ModelResource implements HasImportExportContract
{
    use ImportExportConcern;
    protected string $model = Inventario::class;

    protected string $title = 'Inventario';

    protected bool $createInModal = false;
    protected bool $detailInModal = true;
    protected bool $editInModal = false;

    protected bool $simplePaginate = true;
    protected int $itemsPerPage = 8;

    protected bool $columnSelection = true;

    //mensajes de error desactivados
    protected bool $isAsync = false;
    protected bool $errorsAbove = false;

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            Text::make('Articulo', 'nombre')->sortable(),
            Text::make('Precio')->sortable(),
            Text::make('Existencias')->sortable(),
            Text::make('Categoria', 'categoria.tipo'),
            Image::make('Foto', 'foto')->modifyRawValue(fn(
                ?string $raw
            ): string => $raw ?? ''),
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
                    Text::make('Articulo', 'nombre'),
                    Text::make('Precio'),
                ]),
                Flex::make([
                    Text::make('Existencias'),
                    Select::make('Categoria', 'tipo_categoria')
                        ->options(
                            Categorias::all()->pluck('tipo', 'id')->toArray()
                        )->searchable(),
                ]),
                Text::make('Descripcion'),
                Image::make('Foto', 'foto')
                    ->disk('public')
                    ->dir('Articulos')
                    ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif']),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            Text::make('Articulo', 'nombre'),
            Text::make('Precio'),
            Text::make('Existencias'),
            Text::make('Descripcion'),
            Text::make('Categoria', 'categoria.tipo'),
            Image::make('Foto', 'foto')->modifyRawValue(fn(
                ?string $raw
            ): string => $raw ?? ''),
        ];
    }

    /**
     * @param Inventario $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'nombre' => ['required'], // Validar que el nombre no esté vacío
            'precio' => ['required', 'numeric'], // Validar que el precio sea numérico
            'existencias' => ['required', 'integer'], // Validar que las existencias sean enteros
            'descripcion' => ['required'], // Validar que la descripción no esté vacía
            'tipo_categoria' => ['required'], // Validar que la categoría no esté vacía
            'foto' => ['nullable', 'image', 'max:400'],

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
            'nombre.required' => 'El nombre del artículo no puede estar vacío.',
            'precio.required' => 'El precio no puede estar vacío.',
            'precio.numeric' => 'El precio debe ser un valor numérico.',
            'existencias.required' => 'Las existencias no pueden estar vacías.',
            'existencias.integer' => 'Las existencias deben ser un número entero.',
            'descripcion.required' => 'La descripción no puede estar vacía.',
            'tipo_categoria.required' => 'La categoría no puede estar vacía.',
            'foto.max' => 'La imagen pesa mucho. (Imagen requerida menor a 400 KB).',
        ];
    }

    protected function search(): array
    {
        return [
            'nombre',
            'precio',
            'existencias',
            'descripcion',
            'tipo_categoria',
            'categoria.tipo',
        ];
    }

    protected function exportFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Articulo', 'nombre'),
            Text::make('Precio'),
            Text::make('Existencias'),
            Text::make('Descripcion'),
            Text::make('Categoria', 'categoria.tipo'),
        ];
    }

    protected function export(): ?ExportHandler
    {
        return ExportHandler::make(__('Exportar'))
            ->modifyButton(
                fn(ActionButton $btn) => $btn
                    ->icon('arrow-top-right-on-square')
            );
    }

    protected function importFields(): iterable
    {
        return [];
    }

    protected function import(): ?ImportHandler
    {
        return null;
    }

    protected function filters(): iterable
    {
        return [
            BelongsTo::make(
                __('Categoria'),
                'categoria',
                formatted: static fn(Categorias $model) => $model->tipo,
                resource: MoonShineUserRoleResource::class,
            ),
        ];
    }
}
