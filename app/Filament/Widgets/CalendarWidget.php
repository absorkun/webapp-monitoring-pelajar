<?php

namespace App\Filament\Widgets;

use App\Models\CalendarEvent;
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

    // public function createEvent(array $data): array
    // {
    //     $event = CalendarEvent::create($data);

    //     return [
    //         'id' => $event->id,
    //         'title' => $event->title,
    //         'start' => $event->start,
    //         'end' => $event->end,
    //     ];
    // }

    // public function updateEvent(array $data): array
    // {
    //     $event = CalendarEvent::findOrFail($data['id']);
    //     $event->update($data);

    //     return [
    //         'id' => $event->id,
    //         'title' => $event->title,
    //         'start' => $event->start,
    //         'end' => $event->end,
    //     ];
    // }

    // public function deleteEvent(array $data): bool
    // {
    //     $event = CalendarEvent::findOrFail($data['id']);
    //     return $event->delete();
    // }
}
