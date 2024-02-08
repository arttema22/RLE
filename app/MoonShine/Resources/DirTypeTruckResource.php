<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use MoonShine\Fields\Text;
use App\Models\DirTypeTruck;
use MoonShine\Fields\Number;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Textarea;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;


/**
 * @extends ModelResource<DirTypeTruck>
 */
class DirTypeTruckResource extends ModelResource
{
    protected string $model = DirTypeTruck::class;

    public function title(): string
    {
        return __('moonshine::ui.dir.truck.dir_type_trucks');
    }

    protected string $sortColumn = 'title'; // Поле сортировки по умолчанию

    protected string $sortDirection = 'DESC'; // Тип сортировки по умолчанию

    protected int $itemsPerPage = 25; // Количество элементов на странице

    public string $column = 'title'; // Поле для отображения значений в связях и хлебных крошках

    public function redirectAfterSave(): string
    {
        return to_page(resource: DirTypeTruckResource::class);
    }

    public function redirectAfterDelete(): string
    {
        return to_page(resource: DirTypeTruckResource::class);
    }

    public function getActiveActions(): array
    {
        return ['create', 'update', 'delete', 'massDelete'];
    }

    public function indexFields(): array
    {
        return [
            Text::make('title')->sortable()->translatable('moonshine::ui.dir'),
            Text::make('comment')->translatable('moonshine::ui.dir'),
            Switcher::make('is_service')->updateOnPreview()->sortable()->translatable('moonshine::ui.dir'),
            Switcher::make('status')->updateOnPreview()->sortable()->translatable('moonshine::ui.dir'),

        ];
    }

    public function formFields(): array
    {
        return [
            Block::make([
                Grid::make([
                    Column::make([
                        Text::make('title')
                            ->required()
                            ->hint(__('moonshine::ui.dir.truck.title_hint'))
                            ->translatable('moonshine::ui.dir'),
                    ])->columnSpan(8),
                    Column::make([
                        Switcher::make('is_service')
                            ->hint(__('moonshine::ui.dir.truck.switcher_service_hint'))
                            ->translatable('moonshine::ui.dir'),
                    ])->columnSpan(4),
                ]),
            ]),
            Divider::make(),
            Block::make([
                Textarea::make('comment')
                    ->hint(__('moonshine::ui.dir.truck.textarea_hint'))
                    ->translatable('moonshine::ui.dir'),
            ]),
            Divider::make(),
            Switcher::make('status')
                ->hint(__('moonshine::ui.dir.truck.switcher_hint'))
                ->translatable('moonshine::ui.dir'),
            Divider::make(),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'is_service' => ['required', 'boolean'],
            'comment' => ['string', 'min:3', 'nullable'],
            'status' => ['boolean'],
        ];
    }
}
