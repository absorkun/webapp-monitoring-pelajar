<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Exports\TeacherExporter;
use App\Filament\Imports\TeacherImporter;
use App\Filament\Resources\TeacherResource;
use Filament\Actions;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;

class ListTeachers extends ListRecords
{
    protected static string $resource = TeacherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->label('Ekspor')
                ->exporter(TeacherExporter::class)
                ->fileDisk('public')
                ->formats([
                    ExportFormat::Xlsx,
                ])
                ->color(Color::Cyan),
            Actions\ImportAction::make()
                ->label('Impor')
                ->importer(TeacherImporter::class)
                ->hidden(fn () => ! Filament::auth()->user()->isAdmin())
                ->color(Color::Green),
            Actions\CreateAction::make(),
        ];
    }
}
