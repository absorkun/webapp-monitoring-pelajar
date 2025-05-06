<?php

namespace App\Filament\Resources;

use App\Filament\Exports\UserExporter;
use App\Filament\Imports\UserImporter;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $label = 'Pengguna';

    public static function canViewAny(): bool
    {
        return Filament::auth()->user()->isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Pengguna')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                    ->options(User::getRolesOptions)
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pengguna')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'siswa' => 'gray',
                        'guru' => 'warning',
                        'admin' => 'success',
                    })
                    ->label('Role/Peran')
                    ->formatStateUsing(fn($state) => ucwords($state)),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options(User::getRolesOptions),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ExportBulkAction::make()
                        ->exporter(UserExporter::class)
                        ->formats([
                            ExportFormat::Xlsx,
                        ]),
                ]),
            ])
            ->recordUrl(null)
            ->headerActions([
                Tables\Actions\ImportAction::make()
                    ->label(__('Impor'))
                    ->importer(UserImporter::class)
                    ->color(Color::Orange),
                Tables\Actions\ExportAction::make()
                    ->label(__('Ekspor'))
                    ->exporter(UserExporter::class)
                    ->formats([
                        ExportFormat::Xlsx,
                    ])
                    ->color(Color::Emerald),
                Tables\Actions\Action::make('filter_by_role')
                    ->label('Filter')
                    ->form([
                        Forms\Components\Select::make('role')
                            ->options(User::getRolesOptions)
                            ->label('Role'),
                    ])
                    ->color(Color::Amber)
                    ->action(function (array $data, $livewire) {
                        $livewire->tableFilters['role']['value'] = $data['role'];
                    }),
            ]);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
