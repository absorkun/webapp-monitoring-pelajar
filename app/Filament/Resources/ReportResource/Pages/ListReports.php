<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Exports\ReportExporter;
use App\Filament\Imports\ReportImporter;
use App\Filament\Resources\ReportResource;
use App\Filament\Resources\ReportResource\Widgets\StudentScoreChart;
use App\Filament\Resources\ReportResource\Widgets\StudentScoreOverview;
use Filament\Actions;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;

class ListReports extends ListRecords
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderWidgets(): array
    {
        $user = Filament::auth()->user();
        if ($user->isAdmin()) {
            return [];
        }
        
        return [
            StudentScoreOverview::class,
            StudentScoreChart::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->label('Ekspor')
                ->exporter(ReportExporter::class)
                ->fileDisk('public')
                ->formats([
                    ExportFormat::Xlsx,
                ])
                ->color(Color::Cyan),
            Actions\ImportAction::make()
                ->label('Impor')
                ->importer(ReportImporter::class)
                ->hidden(fn() => ! Filament::auth()->user()->isAdmin())
                ->color(Color::Green),
            Actions\CreateAction::make(),
        ];
    }
}
