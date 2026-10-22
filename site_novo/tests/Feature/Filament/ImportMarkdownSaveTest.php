<?php

use App\Models\Category;
use App\Models\Post;
use App\Support\MarkdownBlocksConverter;

/**
 * Reproduz o fluxo real: converter markdown -> gravar o resultado como
 * content_blocks do post -> salvar. Isso é o que estava quebrando com
 * "Argument #2 ($rawState) must be of type ?array, string given" porque
 * o bloco de parágrafo usa um RichEditor, cujo estado em memória precisa
 * ser um documento TipTap (array), não a string HTML final.
 */
test('a post with markdown-imported content blocks can be saved without a RichEditor type error', function () {
    $post = Post::factory()->create(['category_id' => Category::factory()]);

    $markdown = <<<'MD'
        ## Boas práticas com PHP 8.3

        Um **parágrafo** com `código` e uma lista:

        - item um
        - item dois

        ![Capa](https://exemplo.com/capa.png)
        MD;

    $items = MarkdownBlocksConverter::toBuilderItems($markdown);

    // Simula o que o Filament faz ao salvar: percorre o Builder e, para
    // cada bloco de parágrafo, dehydrata o estado do RichEditor (array)
    // de volta pra HTML — é exatamente esse passo que lançava o TypeError.
    $dehydrated = array_map(function (array $item) {
        if ($item['type'] !== 'paragraph') {
            return $item;
        }

        $item['data']['text'] = \Filament\Forms\Components\RichEditor\RichContentRenderer::make($item['data']['text'])->toHtml();

        return $item;
    }, array_values($items));

    $post->content_blocks = $dehydrated;
    $post->save();

    $post->refresh();

    expect($post->content_blocks)->toHaveCount(4)
        ->and($post->content_blocks[0]['type'])->toBe('title')
        ->and($post->content_blocks[1]['type'])->toBe('paragraph')
        ->and($post->content_blocks[1]['data']['text'])->toBeString()
        ->and($post->content_blocks[1]['data']['text'])->toContain('<strong>parágrafo</strong>')
        ->and($post->content_blocks[2]['type'])->toBe('paragraph')
        ->and($post->content_blocks[3]['type'])->toBe('image');
});
