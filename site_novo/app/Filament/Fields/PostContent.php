<?php

namespace App\Filament\Fields;

use App\Filament\Blocks\Image;
use App\Filament\Blocks\Paragraph;
use App\Filament\Blocks\Title;
use Filament\Forms\Components\Builder;

class PostContent
{
    public static function make(string $name): Builder
    {
        return Builder::make($name)
            ->label('Conteúdo')
            ->blocks([
                Title::make(),
                Paragraph::make(),
                Image::make(),
            ])
            ->collapsible()
            ->columnSpanFull();
    }
}
