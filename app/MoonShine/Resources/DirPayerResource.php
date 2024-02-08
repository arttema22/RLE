<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\DirPayer;
use MoonShine\Fields\Text;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Textarea;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends ModelResource<DirPayer>
 */
class DirPayerResource extends ModelResource
{
    protected string $model = DirPayer::class;

    public function title(): string
    {
        return __('moonshine::ui.dir.payer.dir_payers');
    }

    protected string $sortColumn = 'title'; // Поле сортировки по умолчанию

    protected string $sortDirection = 'DESC'; // Тип сортировки по умолчанию

    protected int $itemsPerPage = 25; // Количество элементов на странице

    public string $column = 'title'; // Поле для отображения значений в связях и хлебных крошках

    public function redirectAfterSave(): string
    {
        return to_page(resource: DirPayerResource::class);
    }

    public function redirectAfterDelete(): string
    {
        return to_page(resource: DirPayerResource::class);
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
            Switcher::make('status')->updateOnPreview()->sortable()->translatable('moonshine::ui.dir'),
        ];
    }

    public function formFields(): array
    {
        return [
            Text::make('title')
                ->required()
                ->hint(__('moonshine::ui.dir.payer.title_hint'))
                ->translatable('moonshine::ui.dir'),
            Textarea::make('comment')
                ->hint(__('moonshine::ui.dir.payer.textarea_hint'))
                ->translatable('moonshine::ui.dir'),
            Switcher::make('status')
                ->hint(__('moonshine::ui.dir.payer.switcher_hint'))
                ->translatable('moonshine::ui.dir'),

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
