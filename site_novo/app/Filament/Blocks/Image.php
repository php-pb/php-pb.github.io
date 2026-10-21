<?php

namespace App\Filament\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class Image
{
    public static function make(): Block
    {
        return Block::make('image')
            ->label('Imagem')
            ->schema([
                FileUpload::make('image')
                    ->label('Upload de imagem')
                    ->image()
                    ->disk('public')
                    ->maxSize(5120),

                TextInput::make('url')
                    ->label('ou URL da imagem'),

                Select::make('ratio')
                    ->label('Proporção')
                    ->options(static::getRatios())
                    ->afterStateHydrated(fn ($state, $set) => $state || $set('ratio', '16-9')),

                TextInput::make('alt')
                    ->label('Texto alternativo')
                    ->columnSpanFull(),

                TextInput::make('caption')
                    ->label('Legenda')
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    public static function getRatios(): array
    {
        return [
            '16-9' => '16/9',
            '4-3' => '4/3',
            'free' => 'Livre',
        ];
    }

    public static function getRatioClass(string $ratio): string
    {
        return match ($ratio) {
            '16-9' => 'aspect-video',
            '4-3' => 'aspect-[4/3]',
            default => '',
        };
    }
}
