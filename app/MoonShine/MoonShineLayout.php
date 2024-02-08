<?php

declare(strict_types=1);

namespace App\MoonShine;

use MoonShine\Components\Layout\{
    Content,
    Flash,
    Footer,
    Header,
    LayoutBlock,
    LayoutBuilder,
    Menu,
    Profile,
    Search,
    Sidebar
};
use MoonShine\Components\When;
use MoonShine\Contracts\MoonShineLayoutContract;

final class MoonShineLayout implements MoonShineLayoutContract
{
    public static function build(): LayoutBuilder
    {
        return LayoutBuilder::make([
            Sidebar::make([
                Menu::make()->customAttributes(['class' => 'mt-2']),
                When::make(
                    static fn () => config('moonshine.auth.enable', true),
                    static fn () => [Profile::make(withBorder: true)]
                ),
            ]),
            LayoutBlock::make([
                Flash::make(),
                Header::make([
                    //    Search::make(),
                ]),
                Content::make(),
                Footer::make()->copyright(fn (): string => <<<'HTML'
                        &copy; 2022-2024 Made by
                        <a href="https://itelect.ru/"
                            class="font-semibold text-primary hover:text-secondary"
                            target="_blank"
                        >
                            ITelect
                        </a>
                    HTML)->menu([
                    'https://itelect.ru/docs' => 'Documentation',
                ]),
            ])->customAttributes(['class' => 'layout-page']),
        ]);
    }
}
