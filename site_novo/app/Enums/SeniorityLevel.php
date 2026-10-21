<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum SeniorityLevel: string implements HasColor, HasLabel
{
    case Junior = 'junior';
    case Pleno = 'pleno';
    case Senior = 'senior';

    public function getLabel(): string
    {
        return match ($this) {
            self::Junior => 'Júnior',
            self::Pleno => 'Pleno',
            self::Senior => 'Sênior',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Junior => 'gray',
            self::Pleno => 'info',
            self::Senior => 'success',
        };
    }
}
