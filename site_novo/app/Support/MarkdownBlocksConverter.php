<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\Support\Str;
use League\CommonMark\GithubFlavoredMarkdownConverter;

/**
 * Converte markdown colado pelo autor em blocos compatíveis com o Builder
 * do Filament (title/paragraph/image) usado no campo content_blocks do
 * Post, no mesmo formato que o editor manual de blocos produz.
 */
class MarkdownBlocksConverter
{
    /**
     * @return array<string, array{type: string, data: array<string, mixed>}>
     */
    public static function toBuilderItems(string $markdown): array
    {
        $items = [];

        foreach (static::toBlocks($markdown) as $block) {
            $items[(string) Str::uuid()] = $block;
        }

        return $items;
    }

    /**
     * @return list<array{type: string, data: array<string, mixed>}>
     */
    public static function toBlocks(string $markdown): array
    {
        $html = (new GithubFlavoredMarkdownConverter(['html_input' => 'allow']))->convert($markdown)->getContent();

        $dom = new DOMDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?><div>'.$html.'</div>', LIBXML_NOERROR | LIBXML_NOWARNING);
        libxml_clear_errors();

        $container = $dom->getElementsByTagName('div')->item(0);

        if (! $container) {
            return [];
        }

        $blocks = [];

        foreach ($container->childNodes as $node) {
            if (! $node instanceof DOMElement) {
                continue;
            }

            if (preg_match('/^h[1-6]$/', $node->tagName)) {
                $blocks[] = [
                    'type' => 'title',
                    'data' => [
                        'text' => trim($node->textContent),
                        'level' => self::mapHeadingLevel($node->tagName),
                    ],
                ];

                continue;
            }

            if ($image = self::extractStandaloneImage($node)) {
                $blocks[] = [
                    'type' => 'image',
                    'data' => $image,
                ];

                continue;
            }

            $blocks[] = [
                'type' => 'paragraph',
                'data' => [
                    'text' => self::htmlToRichEditorState($dom->saveHTML($node) ?: ''),
                ],
            ];
        }

        return $blocks;
    }

    /**
     * O campo "text" do bloco de parágrafo é um RichEditor do Filament, cujo
     * estado em memória (antes de salvar) é sempre um documento TipTap em
     * array, não a string HTML final — essa só existe depois que o form é
     * salvo (dehydratado). Como escrevemos esse estado diretamente via
     * $set(), precisamos produzir o mesmo array que o Filament produziria
     * ao carregar o form normalmente, ou o editor quebra ao tentar salvar.
     *
     * @return array<string, mixed>
     */
    private static function htmlToRichEditorState(string $html): array
    {
        $document = RichContentRenderer::make($html)->getEditor()->getDocument();

        return json_decode(json_encode($document), true);
    }

    private static function mapHeadingLevel(string $tagName): string
    {
        return match ($tagName) {
            'h1', 'h2' => 'h2',
            'h3' => 'h3',
            default => 'h4',
        };
    }

    /**
     * @return array{url: string, alt: string, ratio: string}|null
     */
    private static function extractStandaloneImage(DOMElement $node): ?array
    {
        if ($node->tagName !== 'p') {
            return null;
        }

        $images = $node->getElementsByTagName('img');

        if ($images->length !== 1 || trim($node->textContent) !== '') {
            return null;
        }

        $img = $images->item(0);

        return [
            'url' => $img->getAttribute('src'),
            'alt' => $img->getAttribute('alt'),
            'ratio' => '16-9',
        ];
    }
}
