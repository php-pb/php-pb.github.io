<?php

use App\Models\Category;
use App\Models\Post;

test('it has many posts', function () {
    $category = Category::factory()->create();
    $posts = Post::factory()->count(3)->create(['category_id' => $category->id]);
    Post::factory()->create();

    expect($category->posts)->toHaveCount(3)
        ->and($category->posts->pluck('id')->sort()->values()->all())
        ->toBe($posts->pluck('id')->sort()->values()->all());
});
