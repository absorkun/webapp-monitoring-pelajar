<?php

namespace App\Filament\Resources\ReportResource\Widgets;

use App\Models\Report;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentScoreOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Filament::auth()->user();

        $student = $user->student;

        if ($student) {
            $average = $student->reports()->avg('score');
            $formattedScore = number_format($average, 2, ',', '.');

            $total = $student->reports()->sum('score');
            $all = $student->reports()->sum('subject_id');
            $max = $student->reports()->count('score') * 100;

            return [
                Stat::make('Nilai Rata-rata', $formattedScore ?: 'Belum ada data'),
                Stat::make('Nilai Total', $total . ' dari ' . $max ?: 'Belum ada data'),
                Stat::make('Jumlah Mata Pelajaran', $all ?: 'Belum ada data'),
            ];
        }
        return [
            Stat::make('Nilai Rata-rata', 'Data Tidak Ditemukan'),
            Stat::make('Nilai Total', 'Data Tidak Ditemukan'),
            Stat::make('Jumlah Mata Pelajaran', 'Data Tidak Ditemukan'),
        ];
    }
}
