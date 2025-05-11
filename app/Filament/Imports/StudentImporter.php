<?php

namespace App\Filament\Imports;

use App\Models\Student;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class StudentImporter extends Importer
{
    protected static ?string $model = Student::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('user')
                ->label('Username/Email')
                ->requiredMapping()
                ->relationship(resolveUsing: ['email', 'name'])
                ->rules(['required']),
            ImportColumn::make('classroom')
                ->label('Kelas')
                ->relationship(resolveUsing: 'name')
                ->castStateUsing(fn($state) => strtoupper($state)),
            ImportColumn::make('name')
                ->label('Nama Siswa')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nisn')
                ->label('NISN')
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
                ->rules(['required', 'max:255']),
            ImportColumn::make('address')
                ->label('Alamat')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            // ImportColumn::make('is_active')
            //     ->requiredMapping()
            //     ->boolean()
            //     ->rules(['required', 'boolean']),
        ];
    }

    public function resolveRecord(): ?Student
    {
        return Student::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
            'nisn' => $this->data['nisn'],
        ]);

        // return new Student();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your student import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
