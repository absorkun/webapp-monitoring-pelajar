<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Report;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $label = "Laporan Nilai";

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 11;

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
                Forms\Components\Select::make('student_id')
                    ->label('Username/Email')
                    ->relationship('student', 'name')
                    ->required(),
                Forms\Components\Select::make('classroom_id')
                    ->label('Kelas')
                    ->relationship('classroom', 'name')
                    ->required(),
                Forms\Components\Select::make('semester')
                    ->label('Semester')
                    ->options(Report::getSemesters)
                    ->required(),
                Forms\Components\Select::make('subject_id')
                    ->label('Mata Pelajaran')
                    ->relationship('subject', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('score')
                    ->label('Nilai')
                    ->numeric()
                    ->maxValue(100)
                    ->minValue(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = Filament::auth()->user();
                if ($user->isAdmin()) {
                    $query->get();
                } else {
                    $query->where('student_id', $user->student->id);
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Nama Siswa')
                    ->numeric()
                    ->searchable()
                    ->sortable()
                    ->hidden(fn() => ! Filament::auth()->user()->isAdmin()),
                Tables\Columns\TextColumn::make('subject.name')
                    ->label('Mata Pelajaran')
                    ->numeric(),
                Tables\Columns\TextColumn::make('classroom.name')
                    ->label('Kelas')
                    ->alignCenter()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester')
                    ->label('Semester')
                    ->alignCenter()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('score')
                    ->label('Nilai')
                    ->alignCenter()
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('classroom_id')
                    ->label('Kelas')
                    ->relationship('classroom', 'name')
                    ->multiple(),
                Tables\Filters\SelectFilter::make('semester')
                    ->label('Semester')
                    ->options(Report::getSemesters)
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
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
