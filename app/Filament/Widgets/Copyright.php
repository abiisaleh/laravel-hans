<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class Copyright extends Widget
{
    protected static string $view = 'filament.widgets.copyright';

    protected function getViewData(): array
    {
        return [
            'message' => 'Made by abiisaleh 🐱',
        ];
    }
}
