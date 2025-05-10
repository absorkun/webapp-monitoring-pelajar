<?php

namespace App\Filament\Imports;

use App\Models\Attendance;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class AttendanceImporter extends Importer
{
    protected static ?string $model = Attendance::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('classroom')
                ->requiredMapping()
                ->relationship(resolveUsing: ['id', 'name'])
                ->rules(['required']),
            ImportColumn::make('teacher')
                ->requiredMapping()
                ->relationship(resolveUsing: ['id', 'nuptk', 'name'])
                ->rules(['required']),
            ImportColumn::make('subject')
                ->requiredMapping()
                ->relationship(resolveUsing: ['id', 'name'])
                ->rules(['required']),
            ImportColumn::make('student')
                ->requiredMapping()
                ->relationship(resolveUsing: ['id', 'nisn', 'name'])
                ->rules(['required']),
            ImportColumn::make('date')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('start')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('end')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('status')
                ->requiredMapping()
                ->castStateUsing(fn($state) => strtoupper($state))
                ->rules(['required', 'max:255']),
        ];
    }

    public function resolveRecord(): ?Attendance
    {
        // return Attendance::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'student_id' => $this->data['student'],
        //     'subject_id' => $this->data['subject'],
        //     'date' => $this->data['date'],
        // ]);

        return new Attendance();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your attendance import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
