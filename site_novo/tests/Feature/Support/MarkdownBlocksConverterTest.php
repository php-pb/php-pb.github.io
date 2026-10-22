<?php

use App\Support\MarkdownBlocksConverter;

test('it converts headings into title blocks with clamped levels', function () {
    $blocks = MarkdownBlocksConverter::toBlocks("# Nível 1\n\n## Nível 2\n\n### Nível 3\n\n##### Nível 5");

    expect($blocks)->toHaveCount(4)
        ->and($blocks[0])->toBe(['type' => 'title', 'data' => ['text' => 'Nível 1', 'level' => 'h2']])
        ->and($blocks[1])->toBe(['type' => 'title', 'data' => ['text' => 'Nível 2', 'level' => 'h2']])
        ->and($blocks[2])->toBe(['type' => 'title', 'data' => ['text' => 'Nível 3', 'level' => 'h3']])
        ->and($blocks[3])->toBe(['type' => 'title', 'data' => ['text' => 'Nível 5', 'level' => 'h4']]);
});

test('it converts a plain paragraph into a paragraph block with its html', function () {
    $blocks = MarkdownBlocksConverter::toBlocks('Um **parágrafo** com `código`.');

    expect($blocks)->toHaveCount(1)
        ->and($blocks[0]['type'])->toBe('paragraph')
        ->and($blocks[0]['data']['text'])->toBe('<p>Um <strong>parágrafo</strong> com <code>código</code>.</p>');
});

test('it converts a list into a paragraph block preserving the list markup', function () {
    $blocks = MarkdownBlocksConverter::toBlocks("- um\n- dois");

    expect($blocks)->toHaveCount(1)
        ->and($blocks[0]['type'])->toBe('paragraph')
        ->and($blocks[0]['data']['text'])->toContain('<ul>')
        ->and($blocks[0]['data']['text'])->toContain('<li>um</li>');
});

test('a standalone image paragraph becomes its own image block', function () {
    $blocks = MarkdownBlocksConverter::toBlocks('![Legenda](https://exemplo.com/foto.png)');

    expect($blocks)->toHaveCount(1)
        ->and($blocks[0])->toBe([
            'type' => 'image',
            'data' => [
                'url' => 'https://exemplo.com/foto.png',
                'alt' => 'Legenda',
                'ratio' => '16-9',
            ],
        ]);
});

test('an image inline with text stays inside the paragraph block instead of becoming its own block', function () {
    $blocks = MarkdownBlocksConverter::toBlocks('Veja a imagem: ![alt](https://exemplo.com/a.png) ao lado do texto.');

    expect($blocks)->toHaveCount(1)
        ->and($blocks[0]['type'])->toBe('paragraph')
        ->and($blocks[0]['data']['text'])->toContain('<img');
});

test('toBuilderItems wraps each block with a unique uuid key, matching the filament builder format', function () {
    $items = MarkdownBlocksConverter::toBuilderItems("## Título\n\nParágrafo.");

    expect($items)->toHaveCount(2);

    $keys = array_keys($items);

    expect($keys[0])->toMatch('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/')
        ->and($items[$keys[0]]['type'])->toBe('title')
        ->and($items[$keys[1]]['type'])->toBe('paragraph');
});

test('a full article converts into a sequence of blocks in document order', function () {
    $markdown = <<<'MD'
        ## Boas práticas com PHP 8.3

        Introdução do artigo.

        ![Capa](https://exemplo.com/capa.png)

        ### Tipos nativos

        Mais um parágrafo explicando tipos.
        MD;

    $blocks = MarkdownBlocksConverter::toBlocks($markdown);

    expect(array_column($blocks, 'type'))->toBe(['title', 'paragraph', 'image', 'title', 'paragraph']);
});
