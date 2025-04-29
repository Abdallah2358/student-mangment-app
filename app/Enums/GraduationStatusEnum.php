<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum GraduationStatusEnum: int implements HasLabel, HasColor
{
    case ACTIVE = 0;
    case INACTIVE = 1;
    case GRADUATED = 2;


    public function getLabel(): ?string
    {

        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
            self::GRADUATED => 'Graduated',
        };
    }
    public function getColor(): string | array | null
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::INACTIVE => 'danger',
            self::GRADUATED => 'primary',
        };
    }
}
