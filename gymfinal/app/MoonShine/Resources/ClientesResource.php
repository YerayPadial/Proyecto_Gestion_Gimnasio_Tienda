<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Clientes;
use App\Models\Cuotas;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\Image;
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

/**
 * @extends ModelResource<Clientes>
 */
class ClientesResource extends ModelResource implements HasImportExportContract
{
    use ImportExportConcern;

    protected string $model = Clientes::class;

    protected string $title = 'Clientes';
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
            Text::make('Nombre')->sortable(),
            Text::make('Apellidos')->sortable(),
            Date::make('Inicio', 'fecha_inicio')->format("d.m.Y")->sortable(),
            Date::make('Caducidad', 'fecha_caducidad')->format("d.m.Y")->sortable(),
            Text::make('Cuota', 'cuota.tipo'),
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
                    Text::make('Nombre'),
                    Text::make('Apellidos'),
                ]),
                Flex::make([
                    Text::make('Dni'),
                    Text::make('Telefono'),
                    Text::make('Email'),
                ]),
                Flex::make([
                    Date::make('Fecha de inicio', 'Fecha_inicio')
                        ->format("d.m.Y")
                        ->default(now()->toDateTimeString()),
                    Date::make('Fecha de caducidad', 'Fecha_caducidad')
                        ->format("d.m.Y")
                        ->default(now()->addMonth()->toDateTimeString()),
                ]),
                Select::make('Cuota', 'tipo_cuota')
                    ->options(
                        Cuotas::all()->pluck('tipo', 'id')->toArray() // Obtiene todas las cuotas y las convierte en un array [id => tipo]
                    )->default('3')
                    ->searchable(),
                Image::make('Foto', 'foto') // Campo para subir la imagen
                    ->disk('public') // Define el disco donde se almacenará la imagen
                    ->dir('clientes') // Carpeta donde se guardarán las imágenes
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
            Text::make('Nombre'),
            Text::make('Apellidos'),
            Text::make('Dni'),
            Text::make('Email'),
            Text::make('Telefono'),
            Text::make('Fecha_inicio'),
            Text::make('Fecha_caducidad'),
            Text::make('Cuota', 'cuota.tipo'),
            //obtengo el raw de la foto (serie binaria identificativa que guarda todo sobre la imagen)
            Image::make('Foto', 'foto')->modifyRawValue(fn(
                ?string $raw
            ): string => $raw ?? ''), //si esta vacio devuelvo string vacio para evitar errores
        ];
    }

    protected function search(): array
    {
        return [
            'Nombre',
            'Apellidos',
            'Telefono',
            'Dni',
            'email',
            'tipo_cuota',
            'Fecha_inicio',
            'Fecha_caducidad',
        ];
    }

    /**
     * @param Clientes $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'nombre' => ['required'],
            'apellidos' => ['required'],
            'dni' => [
                'required',
                'regex:/^[0-9]{8}[A-Za-z]$/',
                'unique:clientes,dni' . ($item?->id ? ',' . $item->id : ''),
            ],
            'email' => ['required', 'email'],
            'telefono' => ['required', 'numeric'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_caducidad' => ['required', 'date', 'after_or_equal:fecha_inicio'],
            'tipo_cuota' => ['required'],
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
            'nombre.required' => 'El nombre no puede estar vacío.',
            'apellidos.required' => 'Los apellidos no pueden estar vacíos.',
            'dni.required' => 'El DNI no puede estar vacío.',
            'dni.regex' => 'El formato del DNI es incorrecto. Debe contener 8 números seguidos de una letra.',
            'telefono.required' => 'El teléfono no puede estar vacío.',
            'telefono.numeric' => 'El teléfono debe contener solo números.',
            'fecha_inicio.required' => 'La fecha de inicio no puede estar vacía.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_caducidad.required' => 'La fecha de caducidad no puede estar vacía.',
            'fecha_caducidad.date' => 'La fecha de caducidad debe ser una fecha válida.',
            'fecha_caducidad.after_or_equal' => 'La fecha de caducidad no puede ser anterior a la fecha de inicio.',
            'tipo_cuota.required' => 'La cuota no puede estar vacía.',
            'dni.unique' => 'Este DNI ya corresponde a otro cliente.',
            'foto.max' => 'La imagen pesa mucho. (Imagen requerida menor a 400 KB).',
        ];
    }

    protected function exportFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Nombre'),
            Text::make('Apellidos'),
            Date::make('Fecha_inicio'),
            Date::make('Fecha_caducidad'),
            Text::make('Cuota', 'cuota.tipo'),
        ];
    }

    protected function export(): ?ExportHandler
    {
        return ExportHandler::make(__('Exportar')) // Título del botón
            ->modifyButton(
                fn(ActionButton $btn) => $btn
                    ->icon('arrow-top-right-on-square')
            );
    }

    protected function importFields(): iterable
    {
        return [
            Text::make('Nombre')->required(),
            Text::make('Apellidos')->required(),
            Text::make('Dni')->required(),
            Text::make('Telefono')->required(),
            Date::make('Fecha_inicio')->required(),
            Date::make('Fecha_caducidad')->required(),
            Select::make('Cuota', 'tipo_cuota')
                ->options(Cuotas::all()->pluck('tipo', 'id')->toArray())
                ->required(),
        ];
    }

    protected function import(): ?ImportHandler
    {
        return null;
    }

    protected function filters(): iterable
    {
        return [
            BelongsTo::make(
                __('Cuotas'),
                'cuota',
                formatted: static fn(Cuotas $model) => $model->tipo,
                resource: MoonShineUserRoleResource::class,
            ),
        ];
    }
}
