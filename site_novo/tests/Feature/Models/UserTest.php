<?php

use App\Models\Post;
use App\Models\User;
use Filament\Panel;
use Illuminate\Support\Facades\Storage;

test('it has many posts', function () {
    $author = User::factory()->create();
    $posts = Post::factory()->count(2)->create(['author_id' => $author->id]);
    Post::factory()->create();

    expect($author->posts)->toHaveCount(2)
        ->and($author->posts->pluck('id')->sort()->values()->all())
        ->toBe($posts->pluck('id')->sort()->values()->all());
});

test('getAvatar returns the storage url when an avatar is set', function () {
    $user = User::factory()->create(['avatar' => 'avatars/user.jpg']);

    expect($user->getAvatar())->toBe(Storage::disk('public')->url('avatars/user.jpg'));
});

test('getAvatar returns null when there is no avatar', function () {
    $user = User::factory()->create(['avatar' => null]);

    expect($user->getAvatar())->toBeNull();
});

test('only admins can access the admin panel', function () {
    $admin = User::factory()->admin()->create();
    $member = User::factory()->create();

    $adminPanel = Panel::make()->id('admin');

    expect($admin->canAccessPanel($adminPanel))->toBeTrue()
        ->and($member->canAccessPanel($adminPanel))->toBeFalse();
});

test('any authenticated user can access the member panel', function () {
    $admin = User::factory()->admin()->create();
    $member = User::factory()->create();

    $memberPanel = Panel::make()->id('membro');

    expect($admin->canAccessPanel($memberPanel))->toBeTrue()
        ->and($member->canAccessPanel($memberPanel))->toBeTrue();
});
