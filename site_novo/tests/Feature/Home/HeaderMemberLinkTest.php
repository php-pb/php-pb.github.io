<?php

use App\Models\User;

test('a guest sees a link to login/register in the header', function () {
    $this->get(route('home'))
        ->assertSee('Entrar')
        ->assertSee(route('filament.membro.auth.login'), false);
});

test('an authenticated user sees a link to their member dashboard in the header', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'web')
        ->get(route('home'))
        ->assertSee('Meu painel')
        ->assertSee(route('filament.membro.pages.dashboard'), false);
});

test('the join section mentions the member panel and links to registration', function () {
    $this->get(route('home'))
        ->assertSee('Temos um painel de membros')
        ->assertSee(route('filament.membro.auth.register'), false);
});
