<?php

namespace App\Filament\Exports;

use App\Models\Teacher;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TeacherExporter extends Exporter
{
    protected static ?string $model = Teacher::class;

    public static function getColumns(): array
    {
        return [
            // ExportColumn::make('id')->label('ID'),
            ExportColumn::make('name')->label('Nama Guru'),
            ExportColumn::make('nuptk')->label('NUPTK'),
            ExportColumn::make('gender')->label('Jenis Kelamin'),
            ExportColumn::make('subject.name')->label('Mata Pelajaran'),
            ExportColumn::make('user.email')->label('Username/Email'),
            ExportColumn::make('birthdate')->label('Tanggal Lahir'),
            ExportColumn::make('address')->label('Alamat'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your teacher export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
