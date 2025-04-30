<?php
// app/Enums/GuardianRelationEnum.php
namespace App\Enums;

enum GuardianRelationEnum: int
{
    case Father = 1;
    case Mother = 2;
    case Other = 3;

    public function getLabel(): string
    {
        return match ($this) {
            self::Father => 'Father',
            self::Mother => 'Mother',
            self::Other => 'Other',
        };
    }
    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Father => 'info',
            self::Mother => 'pink',
            self::Other => 'warning',
        };
    }
}
