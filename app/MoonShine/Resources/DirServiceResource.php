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
use MoonShine\Enums\ClickAction;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Decorations\Heading;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Components\FlexibleRender;

/**
 * @extends ModelResource<DirService>
 */
class DirServiceResource extends ModelResource
{
    protected string $model = DirService::class;

    // protected string $title = 'DirServices';
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

    // protected ?ClickAction $clickAction = ClickAction::EDIT;



    public function indexFields(): array
    {
        return [
            Text::make('title')->sortable()->translatable('moonshine::ui.dir.service'),
            Text::make('price')->sortable()->translatable('moonshine::ui.dir.service'),
            Text::make('comment')->translatable('moonshine::ui.dir.service'),
            Switcher::make('status')->updateOnPreview()->sortable()->translatable('moonshine::ui.dir.service'),
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
                            ->hint(__('Поле должно содержать информацию о названии дополнительной услуги.
                            Именно это название будет в дальнейшем использоваться в списках выбора услуги.'))
                            ->translatable('moonshine::ui.dir.service'),
                    ])->columnSpan(8),
                    Column::make([
                        Number::make('price')
                            ->required()
                            ->hint(__('Поле должно содержать стоимость дополнительной услуги.
                            Именно эта стоимость будет в дальнейшем использоваться в расчетах и начислениях.'))
                            ->translatable('moonshine::ui.dir.service'),
                    ])->columnSpan(4),
                ]),
            ]),
            Divider::make(),
            Block::make([
                FlexibleRender::make(__('')),
                Textarea::make('comment')
                    ->hint(__('Поле позволяет хранить любую дополнительную информацию к услуге.
                            Заполнять поле не обязательно.'))
                    ->translatable('moonshine::ui.dir.service'),
            ]),
            Divider::make(),
            Switcher::make('status')
                ->hint(__('Включает/Выключает услугу'))
                ->translatable('moonshine::ui.dir.service'),
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

    // public function queryTags(): array
    // {
    //     return [
    //         QueryTag::make(
    //             'worked',
    //             fn (Builder $query) => $query
    //         )->translatable('moonshine::ui.dir.service')
    //             ->default(),

    //         QueryTag::make(
    //             'all',
    //             fn (Builder $query) => $query->withTrashed()
    //         )->translatable('moonshine::ui.dir.service'),

    //         QueryTag::make(
    //             'deleted',
    //             fn (Builder $query) => $query->onlyTrashed()
    //         )->translatable('moonshine::ui.dir.service'),
    //     ];
    // }

}
