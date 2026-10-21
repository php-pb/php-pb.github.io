<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum WorkMode: string implements HasColor, HasLabel
{
    case Presencial = 'presencial';
    case Remoto = 'remoto';
    case Hibrido = 'hibrido';

    public function getLabel(): string
    {
        return match ($this) {
            self::Presencial => 'Presencial',
            self::Remoto => 'Remoto',
            self::Hibrido => 'Híbrido',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Presencial => 'success',
            self::Remoto => 'info',
            self::Hibrido => 'warning',
        };
    }
}
