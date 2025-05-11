<?php

namespace App\Filament\Exports;

use App\Models\Attendance;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class AttendanceExporter extends Exporter
{
    protected static ?string $model = Attendance::class;

    public static function getColumns(): array
    {
        return [
            // ExportColumn::make('id')->label('ID'),
            ExportColumn::make('classroom.name')->label('Kelas'),
            ExportColumn::make('teacher.name')->label('Nama Guru'),
            ExportColumn::make('subject.name')->label('Mata Pelajaran'),
            ExportColumn::make('student.name')->label('Nama Siswa'),
            ExportColumn::make('date')->label('Tanggal'),
            ExportColumn::make('start')->label('Waktu Mulai'),
            ExportColumn::make('end')->label('Waktu Berakhir'),
            ExportColumn::make('status')->label('Status/Keterangan'),
            // ExportColumn::make('created_at'),
            // ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your attendance export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
