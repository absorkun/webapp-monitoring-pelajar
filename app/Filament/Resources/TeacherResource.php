<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Filament\Resources\TeacherResource\RelationManagers;
use App\Models\Teacher;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $label = 'Data Guru';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 4;

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
                    ->relationship('user', 'email', fn(Builder $query) => $query->where('role', 'guru')->whereDoesntHave('teacher'))
                    ->unique(ignoreRecord: true)
                    ->label('Username/Email')
                    ->required(fn($context) => $context === 'create'),
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('subject_id')
                    ->label('Mata Pelajaran')
                    ->relationship('subject', 'name'),
                Forms\Components\TextInput::make('nuptk')
                    ->label('NUPTK/NIK')
                    ->numeric()
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(255),
                Forms\Components\Radio::make('gender')
                    ->label('Jenis Kelamin')
                    ->options(Teacher::getGenders)
                    ->formatStateUsing(fn($state) => strtoupper($state))
                    ->inline(false)
                    ->required(),
                Forms\Components\DatePicker::make('birthdate')
                    ->label('Tanggal Lahir')
                    ->required(),
                Forms\Components\TextInput::make('address')
                    ->label('Alamat'),
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
                Tables\Columns\TextColumn::make('nuptk')
                    ->label('NUPTK')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject.name')
                    ->label('Mata Pelajaran')
                    ->numeric()
                    ->searchable(),
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
                Tables\Columns\TextColumn::make('birthdate')
                    ->label('Tanggal Lahir')
                    ->date(format: 'd F Y', timezone: 'Asia/Jakarta'),
                Tables\Columns\TextColumn::make('address')
                    ->label('Alamat')
                    ->lineClamp(1),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->numeric()
                    ->hidden(fn() => ! Filament::auth()->user()->isAdmin())
                    ->sortable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
}
