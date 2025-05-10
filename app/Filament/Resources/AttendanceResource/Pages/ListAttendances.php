<?php

namespace App\Filament\Resources\AttendanceResource\Pages;

use App\Filament\Exports\AttendanceExporter;
use App\Filament\Imports\AttendanceImporter;
use App\Filament\Resources\AttendanceResource;
use Filament\Actions;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;

class ListAttendances extends ListRecords
{
    protected static string $resource = AttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->label('Ekspor')
                ->exporter(AttendanceExporter::class)
                ->fileDisk('public')
                ->formats([
                    ExportFormat::Xlsx,
                ])
                ->color(Color::Cyan),
            Actions\ImportAction::make()
                ->label('Impor')
                ->importer(AttendanceImporter::class)
                ->hidden(fn() => ! Filament::auth()->user()->isAdmin())
                ->color(Color::Green),
            Actions\CreateAction::make(),
        ];
    }
}
