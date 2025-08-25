<?php

namespace App\Filament\Resources;

use App\Enums\RolesEnum;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema  $Schema ): Schema 
    {
        return $Schema
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Name')
                    ->placeholder('Enter User name'),
                TextInput::make('email')
                    ->required()
                    ->email()
                    ->label('Email')
                    ->placeholder('Enter User email'),
                TextInput::make('phone')
                    ->label('Phone')
                    ->placeholder('Enter User phone number'),
                TextInput::make('address')
                    ->label('Address')
                    ->placeholder('Enter User address'),
                TextInput::make('password')
                    ->required()
                    ->password()
                    ->label('Password')
                    ->placeholder('Enter User password')
                    ->dehydrated(fn($state) => filled($state))
                    ->visibleOn('create'),
                Select::make('role')
                    ->options(collect(RolesEnum::cases())
                        ->mapWithKeys(fn($s) => [$s->value => $s->getLabel()]))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->sortable(),
                TextColumn::make('address')
                    ->label('Address'),
                TextColumn::make('role')
                    ->label('Role')
                    ->formatStateUsing(fn(RolesEnum $state) => $state->getLabel())
                    ->color(fn(RolesEnum $state) => $state->getColor())
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created At'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }


        public static function getLabel(): string
    {
        return __('index.user.title');
    }
    public static function getPluralLabel(): string
    {
        return __('index.user.plural');
    }
}
