<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum EmploymentType: string implements HasLabel
{
    case Clt = 'clt';
    case Pj = 'pj';
    case Freelance = 'freelance';
    case Estagio = 'estagio';

    public function getLabel(): string
    {
        return match ($this) {
            self::Clt => 'CLT',
            self::Pj => 'PJ',
            self::Freelance => 'Freelance',
            self::Estagio => 'Estágio',
        };
    }
}
