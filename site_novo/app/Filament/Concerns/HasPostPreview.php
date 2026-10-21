<?php

namespace App\Filament\Concerns;

use App\Filament\Fields\PostContent;
use Filament\Schemas\Components\Component;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasBuilderPreview;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;

trait HasPostPreview
{
    use HasBuilderPreview;
    use HasPreviewModal;

    protected function getActions(): array
    {
        return [
            PreviewAction::make()->label('Preview Post'),
        ];
    }

    protected function getPreviewModalView(): ?string
    {
        return 'blog.show';
    }

    protected function getPreviewModalDataRecordKey(): ?string
    {
        return 'post';
    }

    protected function getBuilderPreviewView(string $builderName): ?string
    {
        return 'blog.preview-content';
    }

    public static function getBuilderEditorSchema(string $builderName): Component|array
    {
        return PostContent::make('content_blocks')
            ->label('Conteúdo')
            ->columnSpanFull();
    }
}
