<?php

namespace App\Filament\Resources\CalendarEventResource\Pages;

use App\Filament\Resources\CalendarEventResource;
use App\Filament\Widgets\CalendarWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCalendarEvents extends ListRecords
{
    protected static string $resource = CalendarEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
