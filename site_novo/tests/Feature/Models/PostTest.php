<?php

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

test('published scope only returns posts with a published_at in the past', function () {
    $published = Post::factory()->create(['published_at' => now()->subDay()]);
    Post::factory()->unpublished()->create();
    Post::factory()->scheduled()->create();

    expect(Post::published()->get())->toHaveCount(1)
        ->and(Post::published()->first()->id)->toBe($published->id);
});

test('featured scope only returns published posts marked as featured', function () {
    $featured = Post::factory()->featured()->create();
    Post::factory()->create();
    Post::factory()->featured()->unpublished()->create();

    expect(Post::featured()->get())->toHaveCount(1)
        ->and(Post::featured()->first()->id)->toBe($featured->id);
});

test('it belongs to a category and an author', function () {
    $category = Category::factory()->create();
    $author = User::factory()->create();

    $post = Post::factory()->create([
        'category_id' => $category->id,
        'author_id' => $author->id,
    ]);

    expect($post->category)->toBeInstanceOf(Category::class)
        ->and($post->category->id)->toBe($category->id)
        ->and($post->author)->toBeInstanceOf(User::class)
        ->and($post->author->id)->toBe($author->id);
});

test('a pending post with a published_at date is not published', function () {
    $pending = Post::factory()->pending()->create(['published_at' => now()->subDay()]);

    expect(Post::published()->get())->toHaveCount(0)
        ->and($pending->status)->toBe(PostStatus::Pending);
});

test('approving a pending post makes it published', function () {
    $post = Post::factory()->pending()->create();

    $post->update(['status' => PostStatus::Published, 'published_at' => now()]);

    expect(Post::published()->get())->toHaveCount(1)
        ->and(Post::published()->first()->id)->toBe($post->id);
});

test('getMainImage prefers the uploaded image over the external url', function () {
    $post = Post::factory()->create([
        'main_image_upload' => 'posts/uploaded.jpg',
        'main_image_url' => 'https://example.com/image.jpg',
    ]);

    expect($post->getMainImage())->toBe(Storage::disk('public')->url('posts/uploaded.jpg'));
});

test('getMainImage falls back to the external url when there is no upload', function () {
    $post = Post::factory()->create([
        'main_image_upload' => null,
        'main_image_url' => 'https://example.com/image.jpg',
    ]);

    expect($post->getMainImage())->toBe('https://example.com/image.jpg');
});

test('getMainImage returns null when there is no image at all', function () {
    $post = Post::factory()->create([
        'main_image_upload' => null,
        'main_image_url' => null,
    ]);

    expect($post->getMainImage())->toBeNull();
});
