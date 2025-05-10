<?php

namespace App\Filament\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\Widget;

class SchoolBiography extends Widget
{
    protected static string $view = 'filament.widgets.school-biography';

    protected static ?int $sort = 2;

    protected function getViewData(): array
    {
        $user = Filament::auth()->user();

        if ($user->isAdmin()) {
            return [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'created_at' => $user->created_at,
            ];
        }

        return [
            'name' => $user->name ?? '',
            'email' => $user->email ?? '',
            'role' => $user->role ?? '',
            'address' => $user->student->address ?? '',
            'classroom' => $user->student->classroom->name ?? '',
            'gender' => match ($user->student->gender) {
                'L' => 'Laki-laki',
                'P' => 'Perempuan',
            } ?? '',
            'birthdate' => $user->student->birthdate ?? '',
        ];
    }
}
