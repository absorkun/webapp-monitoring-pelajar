<?php

namespace App\Filament\Exports;

use App\Models\Report;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ReportExporter extends Exporter
{
    protected static ?string $model = Report::class;

    public static function getColumns(): array
    {
        return [
            // ExportColumn::make('id'),
            ExportColumn::make('student.name')->label('Nama Siswa'),
            ExportColumn::make('classroom.name')->label('Kelas'),
            ExportColumn::make('semester')->label('Semester'),
            ExportColumn::make('subject.name')->label('Mata Pelajaran'),
            ExportColumn::make('score')->label('Nilai'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your report export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
