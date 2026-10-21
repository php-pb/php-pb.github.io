<?php

use App\Models\User;

test('a member blocked from the admin panel sees the branded 403 page', function () {
    $member = User::factory()->create();

    $this->actingAs($member, 'web')
        ->get('/admin')
        ->assertForbidden()
        ->assertSee('Acesso restrito')
        ->assertSee('Voltar para o início');
});

test('a guest hitting an unknown route sees the branded 404 page', function () {
    $this->get('/rota-que-nao-existe')
        ->assertNotFound()
        ->assertSee('Essa página')
        ->assertSee('Voltar para o início');
});
