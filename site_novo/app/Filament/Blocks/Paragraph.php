<?php

namespace App\Filament\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\RichEditor;

class Paragraph
{
    public static function make(): Block
    {
        return Block::make('paragraph')
            ->label('Parágrafo')
            ->schema([
                RichEditor::make('text')
                    ->label('Texto')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'link', 'orderedList', 'bulletList',
                        'blockquote', 'codeBlock', 'redo', 'undo',
                    ]),
            ]);
    }
}
