<?php

use Filament\Support\Contracts\{HasLabel, HasColor};

enum LessonTypeEnum: int implements HasLabel, HasColor
{
    case PRIVATE = 0;
    case GROUP = 1;
    public function getLabel(): ?string
    {
        return match ($this) {
            self::PRIVATE => 'Private Lesson',
            self::GROUP => 'Group Lesson',
        };
    }
    public function getColor(): string | array | null
    {
        return match ($this) {
            self::PRIVATE => 'success',
            self::GROUP => 'primary',
        };
    }
}
