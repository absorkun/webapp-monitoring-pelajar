<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Exports\UserExporter;
use App\Filament\Imports\UserImporter;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->label('Ekspor')
                ->exporter(UserExporter::class)
                ->fileDisk('public')
                ->formats([
                    ExportFormat::Xlsx,
                ])
                ->color(Color::Cyan),
            Actions\ImportAction::make()
                ->label('Impor')
                ->importer(UserImporter::class)
                ->hidden(fn() => ! Filament::auth()->user()->isAdmin())
                ->color(Color::Green),
            Actions\CreateAction::make(),
        ];
    }
}
