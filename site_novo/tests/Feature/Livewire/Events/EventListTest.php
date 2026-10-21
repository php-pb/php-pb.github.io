<?php

use App\Livewire\Events\EventList;
use App\Models\Event;
use Livewire\Livewire;

test('it shows all published events by default, past and upcoming', function () {
    $upcoming = Event::factory()->create(['title' => 'Meetup Futuro']);
    $past = Event::factory()->past()->create(['title' => 'Meetup Passado']);
    Event::factory()->unpublished()->create(['title' => 'Rascunho']);

    Livewire::test(EventList::class)
        ->assertSet('filter', 'all')
        ->assertCount('events', 2)
        ->assertSee('Meetup Futuro')
        ->assertSee('Meetup Passado')
        ->assertDontSee('Rascunho');
});

test('the upcoming filter only shows future published events', function () {
    $upcoming = Event::factory()->create(['title' => 'Meetup Futuro']);
    Event::factory()->past()->create(['title' => 'Meetup Passado']);

    Livewire::test(EventList::class)
        ->set('filter', 'upcoming')
        ->assertCount('events', 1)
        ->assertSee('Meetup Futuro')
        ->assertDontSee('Meetup Passado');
});

test('the past filter only shows events that already happened', function () {
    Event::factory()->create(['title' => 'Meetup Futuro']);
    Event::factory()->past()->create(['title' => 'Meetup Passado']);

    Livewire::test(EventList::class)
        ->set('filter', 'past')
        ->assertCount('events', 1)
        ->assertSee('Meetup Passado')
        ->assertDontSee('Meetup Futuro');
});
