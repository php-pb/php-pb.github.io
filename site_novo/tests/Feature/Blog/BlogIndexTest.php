<?php

use App\Models\Post;

test('the blog index page loads successfully', function () {
    Post::factory()->count(3)->create();

    $response = $this->get(route('blog.index'));

    $response->assertStatus(200);
    $response->assertSeeLivewire('blog.post-list');
});
