<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\DirCargoResource;
use App\MoonShine\Resources\DirPayerResource;
use App\MoonShine\Resources\DirPetrolStationResource;
use App\MoonShine\Resources\DirServiceResource;
use App\MoonShine\Resources\DirTypeTruckResource;
use MoonShine\Providers\MoonShineApplicationServiceProvider;
use MoonShine\MoonShine;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\Resources\MoonShineUserResource;
use MoonShine\Resources\MoonShineUserRoleResource;

class MoonShineServiceProvider extends MoonShineApplicationServiceProvider
{
    protected function resources(): array
    {
        return [];
    }

    protected function pages(): array
    {
        return [];
    }

    protected function menu(): array
    {
        return [
            MenuGroup::make('directory', [
                MenuItem::make('dir_services', new DirServiceResource())->translatable('moonshine::ui.dir.service'),
                MenuItem::make('dir_petrols', new DirPetrolStationResource())->translatable('moonshine::ui.dir.petrol'),
                MenuItem::make('dir_cargos', new DirCargoResource())->translatable('moonshine::ui.dir.cargo'),
                MenuItem::make('dir_payers', new DirPayerResource())->translatable('moonshine::ui.dir.payer'),
                MenuItem::make('dir_type_trucks', new DirTypeTruckResource())->translatable('moonshine::ui.dir.truck'),
            ])->translatable('moonshine::ui.dir'),

            MenuGroup::make(static fn () => __('moonshine::ui.resource.system'), [
                MenuItem::make(
                    static fn () => __('moonshine::ui.resource.admins_title'),
                    new MoonShineUserResource()
                ),
                MenuItem::make(
                    static fn () => __('moonshine::ui.resource.role_title'),
                    new MoonShineUserRoleResource()
                ),
            ]),
        ];
    }

    /**
     * @return array{css: string, colors: array, darkColors: array}
     */
    protected function theme(): array
    {
        return [
            'colors' => [
                'primary' => '#5DA035',
                'secondary' => '#2A4523',
            ],
        ];
    }
}
