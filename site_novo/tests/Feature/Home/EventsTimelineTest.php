<?php

use App\Models\Event;

test('the home carousel shows upcoming events when they exist', function () {
    Event::factory()->create(['title' => 'Meetup Futuro']);
    Event::factory()->past()->create(['title' => 'Meetup Passado']);

    $this->get(route('home'))
        ->assertSee('Meetup Futuro')
        ->assertDontSee('Meetup Passado');
});

test('the home carousel falls back to past events when there are no upcoming ones', function () {
    Event::factory()->past()->create(['title' => 'Meetup Passado']);

    $this->get(route('home'))
        ->assertSee('Meetup Passado')
        ->assertSee('ENCERRADO');
});

test('the home carousel shows a message when there are no published events at all', function () {
    $this->get(route('home'))
        ->assertSee('Nenhum evento publicado no momento');
});
