<?php

use App\Models\Post;

test('it shows a published post', function () {
    $post = Post::factory()->create([
        'title' => 'Meu Post de Teste',
        'published_at' => now()->subDay(),
    ]);

    $response = $this->get(route('blog.show', $post->slug));

    $response->assertStatus(200);
    $response->assertSee('Meu Post de Teste');
});

test('it returns 404 for an unpublished post', function () {
    $post = Post::factory()->unpublished()->create();

    $this->get(route('blog.show', $post->slug))->assertStatus(404);
});

test('it returns 404 for a post scheduled in the future', function () {
    $post = Post::factory()->scheduled()->create();

    $this->get(route('blog.show', $post->slug))->assertStatus(404);
});

test('it returns 404 for a slug that does not exist', function () {
    $this->get(route('blog.show', 'nao-existe'))->assertStatus(404);
});
