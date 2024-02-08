<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\DirCargo;
use MoonShine\Fields\Text;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Textarea;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends ModelResource<DirCargo>
 */
class DirCargoResource extends ModelResource
{
    protected string $model = DirCargo::class;

    public function title(): string
    {
        return __('moonshine::ui.dir.cargo.dir_cargos');
    }

    protected string $sortColumn = 'title'; // Поле сортировки по умолчанию

    protected string $sortDirection = 'DESC'; // Тип сортировки по умолчанию

    protected int $itemsPerPage = 25; // Количество элементов на странице

    public string $column = 'title'; // Поле для отображения значений в связях и хлебных крошках

    public function redirectAfterSave(): string
    {
        return to_page(resource: DirCargoResource::class);
    }

    public function redirectAfterDelete(): string
    {
        return to_page(resource: DirCargoResource::class);
    }

    public function getActiveActions(): array
    {
        return ['create', 'update', 'delete', 'massDelete'];
    }

    public function indexFields(): array
    {
        return [
            Text::make('title')->sortable()->translatable('moonshine::ui.dir.cargo'),
            Text::make('comment')->translatable('moonshine::ui.dir.cargo'),
            Switcher::make('status')->updateOnPreview()->sortable()->translatable('moonshine::ui.dir.cargo'),
        ];
    }

    public function formFields(): array
    {
        return [
            Text::make('title')
                ->required()
                ->hint(__('Поле должно содержать информацию о названии груза.
                            Именно это название будет в дальнейшем использоваться в списках выбора груза.'))
                ->translatable('moonshine::ui.dir.cargo'),
            Textarea::make('comment')
                ->hint(__('Поле позволяет хранить любую дополнительную информацию о грузе.
                            Заполнять поле не обязательно.'))
                ->translatable('moonshine::ui.dir.cargo'),
            Switcher::make('status')
                ->hint(__('Включает/Выключает груз'))
                ->translatable('moonshine::ui.dir.cargo'),

        ];
    }

    public function rules(Model $item): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'comment' => ['string', 'min:3', 'nullable'],
            'status' => ['boolean'],
        ];
    }
}
