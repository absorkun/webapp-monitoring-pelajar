<?php

namespace App\Filament\Resources\ClassroomResource\Pages;

use App\Filament\Resources\ClassroomResource;
use App\Filament\Resources\ClassroomResource\RelationManagers\StudentsRelationManager;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewClassroom extends ViewRecord
{
    protected static string $resource = ClassroomResource::class;

    public function getRelationManagers(): array
    {
        return [
            StudentsRelationManager::class,
        ];
    }
}
