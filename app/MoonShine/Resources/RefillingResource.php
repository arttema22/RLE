<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Refilling;
use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Fields\Fields;
use MoonShine\Fields\Hidden;
use MoonShine\Fields\Number;
use MoonShine\Attributes\Icon;
use MoonShine\Fields\Textarea;
use Illuminate\Support\Facades\Auth;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Resources\MoonShineUserResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Decorations\Flex;

#[Icon('heroicons.outline.battery-50')]

/**
 * @extends ModelResource<Refilling>
 */
class RefillingResource extends ModelResource
{
    protected string $model = Refilling::class;

    public function title(): string
    {
        return __('moonshine::ui.refilling.refillings');
    }

    protected string $sortColumn = 'date'; // Поле сортировки по умолчанию

    protected string $sortDirection = 'DESC'; // Тип сортировки по умолчанию

    protected int $itemsPerPage = 25; // Количество элементов на странице

    public string $column = 'date'; // Поле для отображения значений в связях и хлебных крошках

    protected bool $detailInModal = true;

    public function redirectAfterSave(): string
    {
        return to_page(resource: RefillingResource::class);
    }

    public function redirectAfterDelete(): string
    {
        return to_page(resource: RefillingResource::class);
    }

    public function query(): Builder
    {
        if (Auth()->user()->moonshine_user_role_id === 1) {
            return parent::query();
        } else {
            return parent::query()
                ->where('driver_id', Auth()->user()->id);
        }
    }

    public function indexFields(): array
    {
        return [
            Date::make('date')->format('d.m.Y')->sortable()->translatable('moonshine::ui.refilling'),
            BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                ->hideOnIndex(fn () => auth()->user()->moonshine_user_role_id !== 1)
                ->translatable('moonshine::ui.refilling'),
            BelongsTo::make('petrolstation', 'petrolStation', resource: new DirPetrolStationResource())
                ->translatable('moonshine::ui.refilling'),
            Text::make(
                'liters / price',
                'cost_car_refueling',
                fn ($item) => $item->num_liters_car_refueling . ' / ' . $item->price_car_refueling
            )->translatable('moonshine::ui.refilling'),
            Number::make('cost_car_refueling')->sortable()->badge(fn ($status, Field $field) => 'secondary')
                ->translatable('moonshine::ui.refilling'),
        ];
    }

    public function formFields(): array
    {
        return [
            BelongsTo::make('owner', 'owner', resource: new MoonShineUserResource())
                ->canSee(fn () => false),

            Flex::make([
                Date::make('date')
                    ->required()
                    ->hint(__('moonshine::ui.refilling.date_hint'))
                    ->translatable('moonshine::ui.refilling'),

                BelongsTo::make('petrolstation', 'petrolStation', resource: new DirPetrolStationResource())
                    ->valuesQuery(fn (Builder $query, Field $field) => $query->where('status', 1))
                    ->searchable()
                    ->required()
                    ->hint(__('moonshine::ui.refilling.petrolstation_hint'))
                    ->translatable('moonshine::ui.refilling'),
            ]),

            BelongsTo::make('driver', 'driver', resource: new MoonShineUserResource())
                ->valuesQuery(fn (Builder $query, Field $field) => $query->where('moonshine_user_role_id', '!=', 1))
                ->canSee(fn () => auth()->user()->moonshine_user_role_id === 1)
                ->searchable()
                ->required()
                ->hint(__('moonshine::ui.refilling.driver_hint'))
                ->translatable('moonshine::ui.refilling'),

            Flex::make([
                Text::make('num_liters_car_refueling')
                    ->reactive(
                        function (Fields $fields, ?string $value): Fields {
                            return tap(
                                $fields,
                                static fn ($fields) => $fields
                                    ->findByColumn('cost_car_refueling')
                                    ?->setValue($value * 2)
                            );
                        }
                    )
                    ->required()
                    ->hint(__('moonshine::ui.refilling.num_liters_car_refueling_hint'))
                    ->translatable('moonshine::ui.refilling'),

                Text::make('price_car_refueling')
                    ->reactive()
                    ->required()
                    ->hint(__('moonshine::ui.refilling.price_car_refueling_hint'))
                    ->translatable('moonshine::ui.refilling'),

                Text::make('cost_car_refueling')
                    ->reactive()
                    ->required()
                    ->hint(__('moonshine::ui.refilling.cost_car_refueling_hint'))
                    ->translatable('moonshine::ui.refilling'),
            ]),

            Textarea::make('comment')
                ->hint(__('moonshine::ui.refilling.comment_hint'))
                ->translatable('moonshine::ui.refilling'),
        ];
    }

    public function detailFields(): array
    {
        return [];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    protected function beforeCreating(Model $item): Model
    {
        request()->merge([
            'owner_id' => auth()->id(),
        ]);
        if (auth()->user()->moonshine_user_role_id !== 1) {
            request()->merge([
                'driver_id' => auth()->id(),
            ]);
        }
        return $item;
    }

    // protected function beforeUpdating(Model $item): Model
    // {
    //     // request()->merge([
    //     //     'owner_id' => auth()->id(),
    //     // ]);
    //     if (auth()->user()->moonshine_user_role_id !== 1) {
    //         request()->merge([
    //             'driver_id' => auth()->id(),
    //         ]);
    //     }
    //     return $item;
    // }

    public function getBadge(): string
    {
        return 'new';
    }
}
