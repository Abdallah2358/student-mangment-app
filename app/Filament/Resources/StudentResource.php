<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, Select, Textarea, Toggle};
use Filament\Tables\Columns\{TextColumn, BadgeColumn};
use App\Enums\{GenderEnum, GuardianRelationEnum, GraduationStatusEnum, RolesEnum};
use Filament\Forms\Components\BelongsToSelect;
use Illuminate\Support\Facades\Auth;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {

        $components = [
            TextInput::make('name')->required(),
            TextInput::make('phone'),
            TextInput::make('guardian_name')->required(),
            TextInput::make('guardian_phone')->required(),
            Select::make('guardian_relation')
                ->options(collect(GuardianRelationEnum::cases())
                    ->mapWithKeys(fn(GuardianRelationEnum $r) => [$r->value => $r->getLabel()]))
                ->required(),
            TextInput::make('address'),
            DatePicker::make('birth_date')
                ->label('Birth Date')
                ->required(),
            DatePicker::make('enrollment_date')
                ->label('Enrollment Date')
                ->required(),
            TextInput::make('class')->required(),
            Select::make('gender')
                ->options(collect(GenderEnum::cases())
                    ->mapWithKeys(fn($s) => [$s->value => $s->getLabel()]))
                ->required(),
            Textarea::make('notes'),
            Select::make('status')
                ->options(collect(GraduationStatusEnum::cases())
                    ->mapWithKeys(fn($s) => [$s->value => $s->getLabel()]))
                ->required(),
        ];
        if (Auth::user()->role === RolesEnum::ADMIN) {
            array_splice($components, 1, 0, [
                Select::make('teacher_id')
                    ->relationship('teacher', 'id')
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->user->name)
                    ->preload()
                    ->required(),
            ]);
        }
        return   $form->schema($components);
    }

    public static function table(Table $table): Table
    {

        $user = Auth::user();
        $teacherCol = new TextColumn('');
        if ($user->role === RolesEnum::ADMIN) {
            $teacherCol = TextColumn::make('teacher.user.name')->label('Teacher')->sortable();
        }
        $components = [
            TextColumn::make('name')->searchable()->sortable(),
            $teacherCol,
            TextColumn::make('birth_date')
                ->date()
                ->label('Birth Date')
                ->sortable(),
            TextColumn::make('gender')
                ->label('gender')
                ->formatStateUsing(fn(GenderEnum $state) => $state->getLabel())
                ->color(fn(GenderEnum $state) => $state->getColor())
                ->sortable(),
            TextColumn::make('class')->sortable(),
            TextColumn::make('guardian_name')->label('Guardian')->searchable(),
            TextColumn::make('guardian_phone')->label('Guardian Phone'),
            TextColumn::make('guardian_relation')
                ->label('Relation')
                ->formatStateUsing(fn(GuardianRelationEnum $state) => $state->getLabel())
                ->color(fn(GuardianRelationEnum $state) => $state->getColor()),
            TextColumn::make('status')
                ->formatStateUsing(fn(GraduationStatusEnum $state) => $state->getLabel())
                ->color(fn(GraduationStatusEnum $state) => $state->getColor())
                ->sortable(),
            TextColumn::make('enrollment_date')
                ->date()
                ->label('Enrollment Date')
                ->sortable(),
        ];

        return $table
            ->columns($components)
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'view' => Pages\ViewStudent::route('/{record}'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();

        if ($user->role === RolesEnum::ADMIN) {
            return parent::getEloquentQuery();
        }
        return parent::getEloquentQuery()->where('teacher_id', Auth::user()->teacher->id);
    }
}
