<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum EventType: string implements HasColor, HasLabel
{
    case Presencial = 'presencial';
    case Online = 'online';

    public function getLabel(): string
    {
        return match ($this) {
            self::Presencial => 'Presencial',
            self::Online => 'Online',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Presencial => 'success',
            self::Online => 'info',
        };
    }
}
