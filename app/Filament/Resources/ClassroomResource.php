<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassroomResource\Pages;
use App\Filament\Resources\ClassroomResource\RelationManagers;
use App\Models\Classroom;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ClassroomResource extends Resource
{
    protected static ?string $model = Classroom::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    protected static ?string $label = 'Ruang Kelas';

    public static function canview(Model $record): bool
    {
        return Filament::auth()->user()->isAdmin();
    }

    public static function canEdit(Model $record): bool
    {
        return Filament::auth()->user()->isAdmin();
    }

    public static function canDelete(Model $record): bool
    {
        return Filament::auth()->user()->isAdmin();
    }

    public static function canDeleteAny(): bool
    {
        return Filament::auth()->user()->isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('grade')
                    ->label('Tingkat Kelas')
                    ->options(['7' => '7', '8' => '8', '9' => '9'])
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Kelas')
                    ->unique()
                    ->formatStateUsing(fn($state) => strtoupper($state))
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->formatStateUsing(fn($state) => strtoupper($state))
                    ->label('Nama Kelas')
                    ->sortable(),
                Tables\Columns\TextColumn::make('grade')
                    ->label('Tingkat Kelas')
                    ->sortable(),
                Tables\Columns\TextColumn::make('students')
                    ->label('Jumlah Siswa')
                    ->formatStateUsing(fn($state, $record) => $record->students()->count())
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(null);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\StudentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassrooms::route('/'),
            'create' => Pages\CreateClassroom::route('/create'),
            'edit' => Pages\EditClassroom::route('/{record}/edit'),
        ];
    }
}
