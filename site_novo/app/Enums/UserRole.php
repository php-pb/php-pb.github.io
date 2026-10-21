<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum UserRole: string implements HasColor, HasLabel
{
    case Admin = 'admin';
    case Member = 'member';

    public function getLabel(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Member => 'Membro',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Admin => 'amber',
            self::Member => 'blue',
        };
    }
}
