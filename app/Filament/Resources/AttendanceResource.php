<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $label = "Laporan Presensi";

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
                    ->label('Siswa')
                    ->relationship('student', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                    
                Forms\Components\Select::make('classroom_id')
                    ->label('Kelas')
                    ->relationship('classroom', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('teacher_id')
                    ->label('Guru')
                    ->relationship('teacher', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('subject_id')
                    ->label('Mata Pelajaran')
                    ->relationship('subject', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\DatePicker::make('date')
                    ->label('Tanggal')
                    ->default(now())
                    ->required(),

                Forms\Components\TimePicker::make('start')
                    ->label('Jam Mulai')
                    ->seconds(false)
                    ->required(),

                Forms\Components\TimePicker::make('end')
                    ->label('Jam Selesai')
                    ->seconds(false)
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Status Kehadiran')
                    ->options([
                        'hadir' => 'Hadir',
                        'izin' => 'Izin',
                        'sakit' => 'Sakit',
                        'alfa' => 'Alfa',
                    ])
                    ->formatStateUsing(fn($state) => strtoupper($state))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Siswa')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('classroom.name')
                    ->label('Kelas')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('teacher.name')
                    ->label('Guru')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('subject.name')
                    ->label('Mapel')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('start')
                    ->label('Mulai')
                    ->time('h:i'),

                Tables\Columns\TextColumn::make('end')
                    ->label('Selesai')
                    ->time('h:i'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'success' => 'HADIR',
                        'warning' => 'IZIN',
                        'info' => 'SAKIT',
                        'danger' => 'ALFA',
                    ])
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status Kehadiran')
                    ->options([
                        'hadir' => 'Hadir',
                        'izin' => 'Izin',
                        'sakit' => 'Sakit',
                        'alfa' => 'Alfa',
                    ]),

                Tables\Filters\SelectFilter::make('classroom_id')
                    ->relationship('classroom', 'name')
                    ->label('Kelas'),

                Tables\Filters\SelectFilter::make('teacher_id')
                    ->relationship('teacher', 'name')
                    ->label('Guru'),

                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('Dari'),
                        Forms\Components\DatePicker::make('until')->label('Sampai'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('date', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('date', '<=', $data['until']));
                    }),
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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
