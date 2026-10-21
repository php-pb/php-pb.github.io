<?php

namespace App\Filament\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class Title
{
    public static function make(): Block
    {
        return Block::make('title')
            ->label('Título')
            ->schema([
                TextInput::make('text')
                    ->label('Texto')
                    ->required(),

                Select::make('level')
                    ->label('Nível')
                    ->options([
                        'h2' => 'H2',
                        'h3' => 'H3',
                        'h4' => 'H4',
                    ])
                    ->afterStateHydrated(fn ($state, $set) => $state || $set('level', 'h2')),
            ])
            ->columns(2);
    }
}
