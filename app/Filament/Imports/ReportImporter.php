<?php

namespace App\Filament\Imports;

use App\Models\Report;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ReportImporter extends Importer
{
    protected static ?string $model = Report::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('student')
                ->requiredMapping()
                ->relationship(resolveUsing: ['nisn', 'id', 'name'])
                ->rules(['required']),
            ImportColumn::make('classroom')
                ->requiredMapping()
                ->relationship(resolveUsing: ['id', 'name'])
                ->castStateUsing(fn($state) => strtoupper($state))
                ->rules(['required']),
            ImportColumn::make('semester')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('subject')
                ->requiredMapping()
                ->relationship(resolveUsing: ['id', 'name'])
                ->castStateUsing(fn($state) => strtoupper($state))
                ->rules(['required']),
            ImportColumn::make('score')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
        ];
    }

    public function resolveRecord(): ?Report
    {
        return Report::firstOrNew([
            'classroom_id' => $this->data['classroom'],
            'semester' => $this->data['semester'],
            'subject_id' => $this->data['subject'],
            'student_id' => $this->data['student'],
        ]);

        // return new Report();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your report import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
