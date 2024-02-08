<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\DirService;
use MoonShine\Fields\Text;
use MoonShine\Fields\Number;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Textarea;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Components\FlexibleRender;

/**
 * @extends ModelResource<DirService>
 */
class DirServiceResource extends ModelResource
{
    protected string $model = DirService::class;

    public function title(): string
    {
        return __('moonshine::ui.dir.service.dir_services');
    }

    protected string $sortColumn = 'title'; // Поле сортировки по умолчанию

    protected string $sortDirection = 'DESC'; // Тип сортировки по умолчанию

    protected int $itemsPerPage = 25; // Количество элементов на странице

    public string $column = 'title'; // Поле для отображения значений в связях и хлебных крошках

    public function redirectAfterSave(): string
    {
        return to_page(resource: DirServiceResource::class);
    }

    public function redirectAfterDelete(): string
    {
        return to_page(resource: DirServiceResource::class);
    }

    public function getActiveActions(): array
    {
        return ['create', 'update', 'delete', 'massDelete'];
    }

    public function indexFields(): array
    {
        return [
            Text::make('title')->sortable()->translatable('moonshine::ui.dir'),
            Text::make('price')->sortable()->translatable('moonshine::ui.dir'),
            Text::make('comment')->translatable('moonshine::ui.dir'),
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
                            ->hint(__('moonshine::ui.dir.service.title_hint'))
                            ->translatable('moonshine::ui.dir'),
                    ])->columnSpan(8),
                    Column::make([
                        Number::make('price')
                            ->required()
                            ->hint(__('moonshine::ui.dir.service.switcher_hint'))
                            ->translatable('moonshine::ui.dir'),
                    ])->columnSpan(4),
                ]),
            ]),
            Divider::make(),
            Block::make([
                Textarea::make('comment')
                    ->hint(__('moonshine::ui.dir.service.textarea_hint'))
                    ->translatable('moonshine::ui.dir'),
            ]),
            Divider::make(),
            Switcher::make('status')
                ->hint(__('moonshine::ui.dir.service.switcher_hint'))
                ->translatable('moonshine::ui.dir'),
            Divider::make(),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'price' => ['required', 'numeric', 'digits_between:1,8'],
            'comment' => ['string', 'min:3', 'nullable'],
            'status' => ['boolean'],
        ];
    }
}
