<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;

test('the import markdown action is available on the admin post edit page', function () {
    $admin = User::factory()->admin()->create();
    $post = Post::factory()->create(['category_id' => Category::factory()]);

    $this->actingAs($admin, 'web')
        ->get("/admin/posts/{$post->id}/edit")
        ->assertOk()
        ->assertSee('Importar Markdown');
});

test('the import markdown action is available on the member post edit page for the post author', function () {
    $author = User::factory()->create();
    $post = Post::factory()->create(['author_id' => $author->id, 'category_id' => Category::factory()]);

    $this->actingAs($author, 'web')
        ->get("/membro/posts/{$post->id}/edit")
        ->assertOk()
        ->assertSee('Importar Markdown');
});
