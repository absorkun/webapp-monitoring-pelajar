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
                ->label('Kelas')
                ->requiredMapping()
                ->relationship(resolveUsing: 'name')
                ->rules(['required']),
            ImportColumn::make('teacher')
                ->label('Nama/NUPTK Guru')
                ->requiredMapping()
                ->relationship(resolveUsing: ['nuptk', 'name'])
                ->rules(['required']),
            ImportColumn::make('subject')
                ->label('Mata Pelajaran')
                ->requiredMapping()
                ->relationship(resolveUsing: 'name')
                ->rules(['required']),
            ImportColumn::make('student')
                ->label('Nama/NISN Siswa')
                ->requiredMapping()
                ->relationship(resolveUsing: ['nisn', 'name'])
                ->rules(['required']),
            ImportColumn::make('date')
                ->label('Tanggal')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('start')
                ->label('Waktu Mulai')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('end')
                ->label('Waktu Berakhir')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('status')
                ->label('Status/Keterangan')
                ->requiredMapping()
                ->castStateUsing(fn($state) => strtoupper($state))
                ->rules(['required', 'max:255']),
        ];
    }

    public function resolveRecord(): ?Attendance
    {
        // Coba dulu mencari record yang ada
        return Attendance::firstOrNew([
            'teacher_id' => $this->data['teacher'],
            'student_id' => $this->data['student'],
            'subject_id' => $this->data['subject'],
            'date' => $this->data['date'],
            // 'start' => $this->data['start'],
            // 'end' => $this->data['end'],
        ]);

        // return new Attendance();
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
