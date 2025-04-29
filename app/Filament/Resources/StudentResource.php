<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, Select, Textarea, Toggle};
use Filament\Tables\Columns\{TextColumn, BadgeColumn};
use App\Enums\{SexEnum, GuardianRelationEnum, GraduationStatusEnum};
use Filament\Forms\Components\BelongsToSelect;
use Illuminate\Support\Facades\Auth;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('phone'),
                TextInput::make('guardian_name')->required(),
                TextInput::make('guardian_phone')->required(),
                Select::make('guardian_relation')
                    ->options(collect(GuardianRelationEnum::cases())
                        ->mapWithKeys(fn($r) => [$r->value => $r->getLabel()]))
                    ->required(),
                TextInput::make('address'),
                TextInput::make('class')->required(),
                Select::make('sex')
                    ->options(collect(SexEnum::cases())
                        ->mapWithKeys(fn($s) => [$s->value => $s->getLabel()]))
                    ->required(),
                Textarea::make('notes'),
                Select::make('status')
                    ->options(collect(GraduationStatusEnum::cases())
                        ->mapWithKeys(fn($s) => [$s->value => $s->getLabel()]))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
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
 
}
