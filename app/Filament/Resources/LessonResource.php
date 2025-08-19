<?php

namespace App\Filament\Resources;

use App\Enums\LessonTypeEnum;
use App\Enums\SurahEnum;
use App\Filament\Resources\LessonResource\Pages;
use App\Filament\Resources\LessonResource\RelationManagers;
use App\Models\Lesson;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getLabel(): string
    {
        return __('lesson.title');
    }

    public static function getPluralLabel(): string
    {
        return __('lesson.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    Select::make('teacher_id')
                        ->label(__('index.teacher.title'))
                        ->options(function () {
                            return Teacher::query()
                                ->join('users', 'users.id', '=', 'teachers.user_id')  // Make sure this join works correctly
                                ->pluck('users.name', 'teachers.id')
                                ->toArray();
                        })
                        ->searchable()
                        ->required(),

                    Select::make('group_id')
                        ->label(__('index.group.title'))
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
                        ->options(LessonTypeEnum::class)
                        ->searchable()
                        ->required(),

                    // ->options(collect(LessonTypeEnum::cases())
                    //     ->mapWithKeys(fn(LessonTypeEnum $r) => [$r->value => $r->getLabel()]))
                    // ->required(),


                    TextInput::make('topic')->label('الموضوع')->nullable(),
                    DatePicker::make('date')->label('التاريخ')->required(),
                    TimePicker::make('start_time')->label('بداية الدرس')->nullable(),
                    TimePicker::make('end_time')->label('نهاية الدرس')->nullable(),
                    TextInput::make('tajwed_rule')->label('قاعدة التجويد')->nullable(),
                ]),

                Section::make('القراءة')->schema([
                    Select::make('read_sora_start_id')
                        ->label('السورة من')
                        ->options(SurahEnum::class)
                        // ->relationship('readSoraStart', 'name')
                        ->searchable()
                        ->preload()
                        ->nullable(),

                    TextInput::make('read_aya_start')->label('الآية من')->numeric()->nullable(),

                    Select::make('read_sora_end_id')
                        ->label('السورة إلى')
                        ->options(SurahEnum::class)
                        // ->relationship('readSoraEnd', 'name')
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
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('teacher.user.name')
                    ->label('المعلم')
                    ->sortable()->searchable(),
                TextColumn::make('student.name')->label('الطالب')->sortable()->searchable(),
                TextColumn::make('group.name')->label('المجموعة')->sortable()->searchable(),
                TextColumn::make('type')->label('نوع الدرس')
                    // ->state(fn (LessonTypeEnum $s) => $s->name)
                    // ->enum([
                    //     1 => 'مجموعة',
                    //     2 => 'فردي',
                    // ])
                    ->sortable()
                    ->searchable(),
                TextColumn::make('date')->label('التاريخ')->date()->sortable(),
                TextColumn::make('start_time')->label('بداية الدرس')->time()->sortable(),
                TextColumn::make('end_time')->label('نهاية الدرس')->time()->sortable(),
            ])->filters([
                    //
                    SelectFilter::make('teacher_id')
                        ->relationship('teacher.user', 'name')
                        ->label('المعلم')
                        ->multiple()
                        ->preload(),
                    SelectFilter::make('student_id')
                        ->relationship('student', 'name')
                        ->label('الطالب')
                        ->multiple()
                        ->preload(),
                    SelectFilter::make('group_id')
                        ->relationship('group', 'name')
                        ->label('المجموعة')
                        ->multiple()
                        ->preload(),
                    SelectFilter::make('type')
                        ->label('نوع الدرس')
                        ->options([
                            1 => 'مجموعة',
                            2 => 'فردي',
                        ])
                        ->multiple()
                        ->preload(),
                    Filter::make('created_at')
                        ->form([
                            DatePicker::make('start_date')
                                ->label('تاريخ البداية')
                                ->placeholder('تاريخ البداية')
                                ->required(),
                            DatePicker::make('end_date')
                                ->label('تاريخ النهاية')
                                ->placeholder('تاريخ النهاية')
                                ->required(),

                        ])->query(function (Builder $query, array $data): Builder {
                            if (!empty($data['start_date'])) {
                                $query->whereDate('created_at', '>=', $data['start_date']);
                            }

                            if (!empty($data['end_date'])) {
                                $query->whereDate('created_at', '<=', $data['end_date']);
                            }
                            return $query;
                        })
                        ->label('تاريخ الإنشاء'),
                    SelectFilter::make('read_sora_start_id')
                        ->relationship('readSoraStart', 'name')
                        ->label('السورة من')
                        ->multiple()
                        ->preload(),
                    SelectFilter::make('read_sora_end_id')
                        ->relationship('readSoraEnd', 'name')
                        ->label('السورة إلى')
                        ->multiple()
                        ->preload(),
                    SelectFilter::make('hafz_sora_start_id')
                        ->relationship('hafzSoraStart', 'name')
                        ->label('السورة من')
                        ->multiple()
                        ->preload(),
                    SelectFilter::make('hafz_sora_end_id')
                        ->relationship('hafzSoraEnd', 'name')
                        ->label('السورة إلى')
                        ->multiple()
                        ->preload(),
                    SelectFilter::make('review_n_sora_start_id')
                        ->relationship('reviewNSoraStart', 'name')
                        ->label('السورة من')
                        ->multiple()
                        ->preload(),
                    SelectFilter::make('review_n_sora_end_id')
                        ->relationship('reviewNSoraEnd', 'name')
                        ->label('السورة إلى')
                        ->multiple()
                        ->preload(),
                    SelectFilter::make('review_f_sora_start_id')
                        ->relationship('reviewFSoraStart', 'name')
                        ->label('السورة من')
                        ->multiple()
                        ->preload(),
                    SelectFilter::make('review_f_sora_end_id')
                        ->relationship('reviewFSoraEnd', 'name')
                        ->label('السورة إلى')
                        ->multiple()
                        ->preload(),
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
