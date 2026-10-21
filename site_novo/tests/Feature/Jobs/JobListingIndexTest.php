<?php

use App\Models\JobListing;

test('the jobs index page loads successfully', function () {
    JobListing::factory()->count(2)->create();

    $response = $this->get(route('jobs.index'));

    $response->assertStatus(200);
});

test('it only shows published and active job listings', function () {
    JobListing::factory()->create(['title' => 'Vaga Visível']);
    JobListing::factory()->unpublished()->create(['title' => 'Rascunho Escondido']);
    JobListing::factory()->expired()->create(['title' => 'Vaga Expirada']);

    $response = $this->get(route('jobs.index'));

    $response->assertSee('Vaga Visível');
    $response->assertDontSee('Rascunho Escondido');
    $response->assertDontSee('Vaga Expirada');
});
