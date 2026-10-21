<?php

use App\Models\Event;

test('the events index page loads successfully', function () {
    Event::factory()->count(2)->create();

    $response = $this->get(route('events.index'));

    $response->assertStatus(200);
});

test('it only shows published and upcoming events', function () {
    $visible = Event::factory()->create(['title' => 'Meetup Visível']);
    Event::factory()->unpublished()->create(['title' => 'Rascunho Escondido']);
    Event::factory()->past()->create(['title' => 'Evento Passado']);

    $response = $this->get(route('events.index'));

    $response->assertSee('Meetup Visível');
    $response->assertDontSee('Rascunho Escondido');
    $response->assertDontSee('Evento Passado');
});
