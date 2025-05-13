<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonResource\Pages;
use App\Filament\Resources\LessonResource\RelationManagers;
use App\Models\Lesson;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    Select::make('teacher_id')
                        ->label('Teacher')
                        ->options(function () {
                            return Teacher::query()
                                ->join('users', 'users.id', '=', 'teachers.user_id')  // Make sure this join works correctly
                                ->pluck('users.name', 'teachers.id')
                                ->toArray();
                        })
                        ->searchable()
                        ->required(),

                    Select::make('group_id')
                        ->label('المجموعة')
                        ->relationship('group', 'name')
                        ->searchable()
                        ->nullable(),

                    Select::make('student_id')
                        ->label('الطالب')
                        ->relationship('student', 'name')
                        ->searchable()
                        ->nullable(),

                    Select::make('type')
                        ->label('نوع الدرس')
                        ->options([
                            1 => 'مجموعة',
                            2 => 'فردي',
                        ])
                        ->default(1)
                        ->required(),

                    TextInput::make('topic')->label('الموضوع')->nullable(),
                    DatePicker::make('date')->label('التاريخ')->required(),
                    TimePicker::make('start_time')->label('بداية الدرس')->nullable(),
                    TimePicker::make('end_time')->label('نهاية الدرس')->nullable(),
                    TextInput::make('tajwed_rule')->label('قاعدة التجويد')->nullable(),
                ]),

                Section::make('القراءة')->schema([
                    Select::make('read_sora_start_id')
                        ->label('السورة من')
                        ->relationship('readSoraStart', 'name')
                        ->searchable()
                        ->preload()
                        ->nullable(),

                    TextInput::make('read_aya_start')->label('الآية من')->numeric()->nullable(),

                    Select::make('read_sora_end_id')
                        ->label('السورة إلى')
                        ->relationship('readSoraEnd', 'name')
                        ->searchable()
                        ->preload()
                        ->nullable(),

                    TextInput::make('read_aya_end')->label('الآية إلى')->numeric()->nullable(),
                ])->columns(2),

                Section::make('الحفظ')->schema([
                    Select::make('hafz_sora_start_id')->label('السورة من')
                        ->relationship('hafzSoraStart', 'name')->searchable()->nullable(),
                    TextInput::make('hafz_aya_start')->label('الآية من')->numeric()->nullable(),
                    Select::make('hafz_sora_end_id')->label('السورة إلى')
                        ->relationship('hafzSoraEnd', 'name')->searchable()->nullable(),
                    TextInput::make('hafz_aya_end')->label('الآية إلى')->numeric()->nullable(),
                ])->columns(2),

                Section::make('ماضي قريب')->schema([
                    Select::make('review_n_sora_start_id')->label('السورة من')
                        ->relationship('reviewNSoraStart', 'name')->searchable()->nullable(),
                    TextInput::make('review_n_aya_start')->label('الآية من')->numeric()->nullable(),
                    Select::make('review_n_sora_end_id')->label('السورة إلى')
                        ->relationship('reviewNSoraEnd', 'name')->searchable()->nullable(),
                    TextInput::make('review_n_aya_end')->label('الآية إلى')->numeric()->nullable(),
                ])->columns(2),

                Section::make('ماضي بعيد')->schema([
                    Select::make('review_f_sora_start_id')->label('السورة من')
                        ->relationship('reviewFSoraStart', 'name')->searchable()->nullable(),
                    TextInput::make('review_f_aya_start')->label('الآية من')->numeric()->nullable(),
                    Select::make('review_f_sora_end_id')->label('السورة إلى')
                        ->relationship('reviewFSoraEnd', 'name')->searchable()->nullable(),
                    TextInput::make('review_f_aya_end')->label('الآية إلى')->numeric()->nullable(),
                ])->columns(2),

                Section::make('مواد إضافية')->schema([
                    TextInput::make('akyda')->label('العقيدة')->nullable(),
                    TextInput::make('hadyth')->label('الحديث')->nullable(),
                    TextInput::make('fiqha')->label('الفقه')->nullable(),
                    TextInput::make('akhlak')->label('الأخلاق')->nullable(),
                ])->columns(2),
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
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'view' => Pages\ViewLesson::route('/{record}'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}
