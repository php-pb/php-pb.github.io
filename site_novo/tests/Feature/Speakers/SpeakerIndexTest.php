<?php

use App\Models\Event;
use App\Models\User;

test('the speakers index page loads successfully', function () {
    $event = Event::factory()->create();
    $speaker = User::factory()->create();
    $event->speakers()->attach($speaker);

    $response = $this->get(route('speakers.index'));

    $response->assertStatus(200);
});

test('it only lists users with at least one speaking event', function () {
    $event = Event::factory()->create();
    $speaker = User::factory()->create(['name' => 'Palestrante Visível']);
    $event->speakers()->attach($speaker);

    User::factory()->create(['name' => 'Usuário Sem Palestra']);

    $response = $this->get(route('speakers.index'));

    $response->assertSee('Palestrante Visível');
    $response->assertDontSee('Usuário Sem Palestra');
});
