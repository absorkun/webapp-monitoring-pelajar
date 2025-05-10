<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;

class SchoolProfileWidget extends Widget
{
    protected static string $view = 'filament.widgets.school-profile-widget';

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 1;


    protected function getViewData(): array
    {
        return [
            'data' => [
                'Nama' => 'MTSS IKHLAS JAWILAN',
                'NSM' => '121236040067',
                'NPSN' => '20622882',
                'Alamat' => 'JL. RAYA CIKANDE RANGKASBITUNG KM.10',
                'Kecamatan' => 'JAWILAN',
                'Kabupaten' => 'KABUPATEN SERANG',
                'Provinsi' => 'BANTEN',
            ],
        ];
    }
}
