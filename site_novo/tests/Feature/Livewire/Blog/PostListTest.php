<?php

use App\Livewire\Blog\PostList;
use App\Models\Category;
use App\Models\Post;
use Livewire\Livewire;

test('it loads published posts and categories on mount', function () {
    $category = Category::factory()->create();

    Post::factory()->count(2)->create(['category_id' => $category->id]);
    Post::factory()->unpublished()->create(['category_id' => $category->id]);
    Category::factory()->create();

    Livewire::test(PostList::class)
        ->assertSet('postCount', 2)
        ->assertCount('posts', 2)
        ->assertCount('categories', 2);
});

test('it filters posts by category slug', function () {
    $matching = Category::factory()->create(['slug' => 'laravel']);
    $other = Category::factory()->create(['slug' => 'php']);

    Post::factory()->count(2)->create(['category_id' => $matching->id]);
    Post::factory()->create(['category_id' => $other->id]);

    Livewire::test(PostList::class)
        ->set('category', 'laravel')
        ->assertSet('postCount', 2)
        ->assertCount('posts', 2);
});

test('it orders posts by published_at ascending or descending', function () {
    $oldest = Post::factory()->create(['published_at' => now()->subDays(3)]);
    $newest = Post::factory()->create(['published_at' => now()->subDay()]);

    Livewire::test(PostList::class)
        ->assertSet('posts.0.id', $newest->id)
        ->set('order', 'date_asc')
        ->assertSet('posts.0.id', $oldest->id);
});

test('loadMore appends the next page of posts', function () {
    Post::factory()->count(PostList::ITEMS_PER_PAGE + 3)->create();

    Livewire::test(PostList::class)
        ->assertCount('posts', PostList::ITEMS_PER_PAGE)
        ->assertSet('hasMore', true)
        ->call('loadMore')
        ->assertCount('posts', PostList::ITEMS_PER_PAGE + 3)
        ->assertSet('hasMore', false);
});

test('changing the category filter resets pagination', function () {
    $category = Category::factory()->create();
    Post::factory()->count(PostList::ITEMS_PER_PAGE + 3)->create();
    Post::factory()->create(['category_id' => $category->id]);

    Livewire::test(PostList::class)
        ->call('loadMore')
        ->set('category', $category->slug)
        ->assertSet('page', 1)
        ->assertCount('posts', 1);
});
