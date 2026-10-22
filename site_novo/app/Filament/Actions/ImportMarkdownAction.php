<?php

namespace App\Filament\Actions;

use App\Support\MarkdownBlocksConverter;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Set;

class ImportMarkdownAction
{
    public static function make(string $field = 'content_blocks'): Action
    {
        return Action::make('importMarkdown')
            ->label('Importar Markdown')
            ->icon('heroicon-o-arrow-up-tray')
            ->color('gray')
            ->modalHeading('Importar artigo em Markdown')
            ->modalDescription('Cole o Markdown completo do artigo. Isso substitui todos os blocos de conteúdo abaixo.')
            ->modalSubmitActionLabel('Converter para blocos')
            ->schema([
                Textarea::make('markdown')
                    ->label('Markdown')
                    ->required()
                    ->rows(18)
                    ->placeholder("## Um título\n\nUm parágrafo com **negrito** e [um link](https://exemplo.com).\n\n![Legenda da imagem](https://exemplo.com/imagem.png)"),
            ])
            ->action(function (array $data, Set $set) use ($field) {
                $set($field, MarkdownBlocksConverter::toBuilderItems($data['markdown']));

                Notification::make()
                    ->title('Markdown convertido em blocos de conteúdo')
                    ->success()
                    ->send();
            });
    }
}
