<?php

namespace App\Filament\Resources\AttendanceResource\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentPresenceWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Filament::auth()->user();

        $student = $user->student;

        if (! ($student)) {
            return [];
        }

        $hadir = $student->attendances()->where('status', 'hadir')->count();
        $sakit = $student->attendances()->where('status', 'sakit')->count();
        $izin = $student->attendances()->where('status', 'izin')->count();
        $alfa = $student->attendances()->where('status', 'alfa')->count();

        return [
            Stat::make('Total Kehadiran', $hadir),
            Stat::make('Total Sakit', $sakit),
            Stat::make('Total Izin', $izin),
            Stat::make('Total Alfa', $alfa),
        ];
    }
}
