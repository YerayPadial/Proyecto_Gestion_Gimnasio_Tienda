<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Machine;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Text;


/**
 * @extends ModelResource<Machine>
 */
class MachineResource extends ModelResource
{
    protected string $model = Machine::class;

    protected string $title = 'Maquinas';

    protected bool $createInModal = true;
    protected bool $detailInModal = true;
    protected bool $editInModal = true;

    protected bool $isAsync = false;
    protected bool $errorsAbove = false;
    
    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Title')->sortable(),
            Text::make('Content')->sortable(),
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
                Text::make('Title'),
                Text::make('Content'),
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
            Text::make('Title'),
            Text::make('Content'),
        ];
    }

    /**
     * @param Machine $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'Title' => ['required', 'string', 'min:3', 'max:255'], // Validar que el título sea obligatorio, texto y tenga entre 3 y 255 caracteres
            'Content' => ['required', 'string', 'min:10'], // Validar que el contenido sea obligatorio, texto y tenga al menos 10 caracteres
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
            'Title.required' => 'El título es obligatorio.',
            'Title.string' => 'El título debe ser una cadena de texto.',
            'Title.min' => 'El título debe tener al menos 3 caracteres.',
            'Title.max' => 'El título no puede tener más de 255 caracteres.',
            'Content.required' => 'El contenido es obligatorio.',
            'Content.string' => 'El contenido debe ser una cadena de texto.',
            'Content.min' => 'El contenido debe tener al menos 10 caracteres.',
        ];
    }

    protected function search(): array
    {
        return [
            'id',
            'Title',
            'Content',
        ];
    }
}
