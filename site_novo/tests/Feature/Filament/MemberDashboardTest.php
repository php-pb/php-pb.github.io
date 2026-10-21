<?php

use App\Filament\Member\Pages\Dashboard;
use App\Filament\Member\Widgets\MyPostsOverview;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

test('it loads successfully for a member', function () {
    $member = User::factory()->create();

    Livewire::actingAs($member)
        ->test(Dashboard::class)
        ->assertSuccessful();
});

test('the overview widget only counts the logged in user\'s own posts', function () {
    $member = User::factory()->create();
    $otherAuthor = User::factory()->create();

    Post::factory()->count(2)->create(['author_id' => $member->id]);
    Post::factory()->pending()->create(['author_id' => $member->id]);
    Post::factory()->unpublished()->create(['author_id' => $member->id]);

    Post::factory()->count(5)->create(['author_id' => $otherAuthor->id]);

    Livewire::actingAs($member)
        ->test(MyPostsOverview::class)
        ->assertSuccessful()
        ->assertSee('Publicados')
        ->assertSee('2')
        ->assertSee('Pendentes')
        ->assertSee('Rascunhos');
});
