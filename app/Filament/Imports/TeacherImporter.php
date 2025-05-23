<?php

namespace App\Filament\Imports;

use App\Models\Teacher;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class TeacherImporter extends Importer
{
    protected static ?string $model = Teacher::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('user')
                ->label('Username/Email')
                ->requiredMapping()
                ->relationship(resolveUsing: ['email', 'name'])
                ->rules(['required']),
            ImportColumn::make('subject')
                ->label('Mata Pelajaran')
                ->relationship(resolveUsing: 'name')
                ->castStateUsing(fn($state) => strtoupper($state)),
            ImportColumn::make('name')
                ->label('Nama Guru')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nuptk')
                ->label('NUPTK')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('gender')
                ->label('Jenis Kelamin')
                ->requiredMapping()
                ->castStateUsing(fn($state) => strtoupper($state))
                ->rules(['required']),
            ImportColumn::make('birthdate')
                ->label('Tanggal Lahir')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('address')
                ->label('Alamat')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
        ];
    }

    public function resolveRecord(): ?Teacher
    {
        return Teacher::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
            'nuptk' => $this->data['nuptk'],
        ]);

        // return new Teacher();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your teacher import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
