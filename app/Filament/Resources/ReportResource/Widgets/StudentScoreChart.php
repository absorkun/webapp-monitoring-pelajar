<?php

namespace App\Filament\Resources\ReportResource\Widgets;

use App\Models\Report;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Contracts\Support\Htmlable;

class StudentScoreChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    public function getHeading(): string|Htmlable|null
    {
        return 'Chart Nilai Siswa';
    }

    protected function getData(): array
    {
        $user = Filament::auth()->user();

        $student = $user->student;

        if ($student) {
            $data = Trend::query(Report::query()->where('student_id', $user->student->id))
                ->between(
                    start: now()->startOfYear(),
                    end: now()->endOfYear(),
                )
                ->perMonth();

            $averate = $data->average('score');
            $sum = $data->sum('score');

            return [
                'datasets' => [
                    [
                        'label' => 'Nilai Rata-rata',
                        'data' => $averate->map(fn(TrendValue $value) => $value->aggregate) ?? [],
                        'backgroundColor' => 'rgba(54, 162, 235, 1)',
                    ],
                    [
                        'label' => 'Nilai Total',
                        'data' => $sum->map(fn(TrendValue $value) => $value->aggregate) ?? [],
                    ],
                ],
                'labels' =>
                $averate->map(fn(TrendValue $value) => $value->date) ?? [],
                $sum->map(fn(TrendValue $value) => $value->date) ?? [],
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Nilai Rata-rata',
                    'data' => [],
                ],
            ],
            'labels' => [],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
