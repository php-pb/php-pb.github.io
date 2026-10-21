<?php

use App\Filament\Pages\Dashboard;
use App\Filament\Widgets\AdminOverview;
use App\Models\Event;
use App\Models\JobListing;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

test('it loads successfully for an admin', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(Dashboard::class)
        ->assertSuccessful();
});

test('the overview widget shows real counts of posts, events and job listings', function () {
    $admin = User::factory()->admin()->create();

    Post::factory()->count(2)->create();
    Post::factory()->pending()->create();
    Post::factory()->unpublished()->create();
    Event::factory()->create();
    JobListing::factory()->create();

    Livewire::actingAs($admin)
        ->test(AdminOverview::class)
        ->assertSuccessful()
        ->assertSee('Publicados')
        ->assertSee('2')
        ->assertSee('Pendentes')
        ->assertSee('Rascunhos')
        ->assertSee('Eventos próximos')
        ->assertSee('Vagas ativas');
});
