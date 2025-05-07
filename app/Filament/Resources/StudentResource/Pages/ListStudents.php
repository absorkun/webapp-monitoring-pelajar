<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Exports\StudentExporter;
use App\Filament\Imports\StudentImporter;
use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->label('Ekspor')
                ->exporter(StudentExporter::class)
                ->fileDisk('public')
                ->formats([
                    ExportFormat::Xlsx,
                ])
                ->color(Color::Cyan),
            Actions\ImportAction::make()
                ->label('Impor')
                ->importer(StudentImporter::class)
                ->hidden(fn () => ! Filament::auth()->user()->isAdmin())
                ->color(Color::Green),
            Actions\CreateAction::make(),
        ];
    }
}
