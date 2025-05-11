<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\CalendarEventResource;
use App\Models\CalendarEvent;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = CalendarEvent::class;

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';


    public function fetchEvents(array $info): array
    {
        return CalendarEvent::query()
            ->where('start', '>=', $info['start'])
            ->where('end', '<=', $info['end'])
            ->get()
            ->map(
                fn(CalendarEvent $event) => EventData::make()
                    ->id($event->id)
                    ->title($event->title)
                    ->start($event->start)
                    ->end($event->end)
                    ->url(
                        url: CalendarEventResource::getUrl(name: 'view', parameters: ['record' => $event]),
                        shouldOpenUrlInNewTab: true,
                    )
            )
            ->toArray();
    }

    public function getFormSchema(): array
    {

        return [
            TextInput::make('title')
                ->label('Judul Event')
                ->required(),
            Grid::make()
                ->schema([
                    DateTimePicker::make('start')
                        ->label('Mulai')
                        ->required(),
                    DateTimePicker::make('end')
                        ->label('Selesai')
                        ->required(),
                ]),
        ];
    }
}
