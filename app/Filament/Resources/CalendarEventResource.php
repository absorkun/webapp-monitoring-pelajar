<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CalendarEventResource\Pages;
use App\Filament\Resources\CalendarEventResource\RelationManagers;
use App\Filament\Widgets\CalendarWidget;
use App\Models\CalendarEvent;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CalendarEventResource extends Resource
{
    protected static ?string $model = CalendarEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-date-range';

    public static function canAccess(): bool
    {
        return Filament::auth()->user()->isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('start')
                    ->label('Waktu Mulai')
                    ->required(),
                Forms\Components\DateTimePicker::make('end')
                    ->label('Waktu Berakhir')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start')
                    ->label('Waktu Mulai')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end')
                    ->label('Waktu Berakhir')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListCalendarEvents::route('/'),
            'create' => Pages\CreateCalendarEvent::route('/create'),
            'edit' => Pages\EditCalendarEvent::route('/{record}/edit'),
            'view' => Pages\ViewCalendarEvent::route('/{record}'),
        ];
    }
}
