<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PostStatus: string implements HasColor, HasLabel
{
    case Draft = 'draft';
    case Pending = 'pending';
    case Published = 'published';
    case Rejected = 'rejected';

    public function getLabel(): string
    {
        return match ($this) {
            self::Draft => 'Rascunho',
            self::Pending => 'Em revisão',
            self::Published => 'Publicado',
            self::Rejected => 'Rejeitado',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Pending => 'warning',
            self::Published => 'success',
            self::Rejected => 'danger',
        };
    }
}
