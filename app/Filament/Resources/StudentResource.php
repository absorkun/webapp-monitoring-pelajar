<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\Student;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $label = 'Data Siswa';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 1;

    public static function canView(Model $record): bool
    {
        return Filament::auth()->user()->isAdmin();
    }

    public static function canCreate(): bool
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
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'email', fn(Builder $query) => $query->where('role', 'siswa')->whereDoesntHave('student'))
                    ->unique(ignoreRecord: true)
                    ->label('Username/Email')
                    ->required(fn($context) => $context === 'create'),
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nisn')
                    ->label('NISN')
                    ->numeric()
                    ->unique()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Radio::make('gender')
                    ->label('Jenis Kelamin')
                    ->options(Student::getGenders)
                    ->formatStateUsing(fn($state) => strtoupper($state))
                    ->inline(false)
                    ->required(),
                Forms\Components\Select::make('classroom_id')
                    ->label('Kelas')
                    ->relationship('classroom', 'name'),
                Forms\Components\Toggle::make('is_active')
                    ->label('Status Keaktifan')
                    ->inline(false)
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->label('NISN')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('classroom.name')
                    ->label('Kelas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Jenis Kelamin')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    })
                    ->color(fn($state) => match ($state) {
                        'L' => 'primary',
                        'P' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->numeric()
                    ->hidden(fn() => ! Filament::auth()->user()->isAdmin())
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status Keaktifan')
                    ->boolean()
                    ->alignCenter()
                    ->hidden(fn() => ! Filament::auth()->user()->isAdmin())
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
                    ->options([true => 'Aktif', false => 'Non Aktif']),
                Tables\Filters\SelectFilter::make('classroom_id')
                    ->label('Kelas')
                    ->relationship('classroom', 'name')
                    ->preload()
                    ->multiple(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
