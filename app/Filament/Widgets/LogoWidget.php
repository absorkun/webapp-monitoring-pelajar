<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class LogoWidget extends Widget
{
    protected static string $view = 'filament.widgets.logo-widget';

     protected static ?int $sort = -1;

    protected int | string | array $columnSpan = 2;
}
