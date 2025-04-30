<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RolesEnum: int implements HasLabel, HasColor
{
    case ADMIN = 0;
    case MODERATOR = 1;
    case TEACHER = 2;
    case GUARDIAN = 3;
    case STUDENT = 4;


    public function getLabel(): ?string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::MODERATOR => 'Moderator',
            self::TEACHER => 'Teacher',
            self::GUARDIAN => 'Guardian',
            self::STUDENT => 'Student',
        };
    }
    public function getColor(): string | array | null
    {
        return match ($this) {
            self::ADMIN => 'info',
            self::MODERATOR => 'secondary',
            self::TEACHER => 'success',
            self::GUARDIAN => 'primary',
            self::STUDENT => 'warning',
        };
    }
}
