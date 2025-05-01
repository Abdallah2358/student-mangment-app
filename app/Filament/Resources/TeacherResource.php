<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Filament\Resources\TeacherResource\RelationManagers;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {

        return $form


            ->schema([

                Grid::make()
                    ->relationship('user')
                // ->schema(
                //     [
                //         TextInput::make('name')
                //             ->required()
                //             ->label('Name')
                //             ->placeholder('Enter User name'),
                //         TextInput::make('email')
                //             ->required()
                //             ->email()
                //             ->label('Email')
                //             ->placeholder('Enter User email'),
                //         TextInput::make('phone')
                //             ->label('Phone')
                //             ->placeholder('Enter User phone number'),
                //         TextInput::make('address')
                //             ->label('Address')
                //             ->placeholder('Enter User address'),
                //         TextInput::make('password')
                //             ->required()
                //             ->password()
                //             ->label('Password')
                //             ->placeholder('Enter User password')
                //             ->dehydrated(fn($state) => filled($state))
                //             ->visibleOn('create'),
                //     ]
                // )
                // ->label('User'),
                ,
                TextInput::make('user.name')
                    ->required()
                    ->label('Name')
              
                    ->placeholder('Enter User name'),
                TextInput::make('user.email')
                    ->required()
                    ->email()
                    ->label('Email')
                    ->placeholder('Enter User email'),
                TextInput::make('user.phone')
                    ->label('Phone')
                    ->placeholder('Enter User phone number'),
                TextInput::make('user.address')
                    ->label('Address')
                    ->placeholder('Enter User address'),
                TextInput::make('user.password')
                    ->required()
                    ->password()
                    ->label('Password')
                    ->placeholder('Enter User password')
                    ->dehydrated(fn($state) => filled($state))
                    ->visibleOn('create'),
                // Select::make('team')->options(collect(RolesEnum::cases())
                //     ->mapWithKeys(fn($s) => [$s->value => $s->getLabel()]))
                //     ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.phone')
                    ->label('Phone')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.address')
                    ->label('Address')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),

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
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'view' => Pages\ViewTeacher::route('/{record}'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
    public static function eagerLoadRelationships(): array
    {
        return ['user'];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user']);
    }
}
