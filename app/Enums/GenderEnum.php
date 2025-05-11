<?php

namespace App\Enums;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
enum GenderEnum: int implements HasLabel, HasColor
{
    case MALE = 0;
    case FEMALE = 1;


    public function getLabel(): ?string
    {
        return match ($this) {
            self::MALE => 'Male',
            self::FEMALE => 'Female',
        };
    }
    public function getColor(): string | array | null
    {
        return match ($this) {
            self::MALE => 'info',
            self::FEMALE => 'warning',
        };
    }
}
