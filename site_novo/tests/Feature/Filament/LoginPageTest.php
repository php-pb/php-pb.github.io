<?php

test('the admin login page renders the split brand layout', function () {
    $this->get('/admin/login')
        ->assertOk()
        ->assertSee('fi-login-brand-panel', false)
        ->assertSee('A comunidade PHP que conecta a Paraíba');
});

test('the member login page renders the split brand layout', function () {
    $this->get('/membro/login')
        ->assertOk()
        ->assertSee('fi-login-brand-panel', false)
        ->assertSee('A comunidade PHP que conecta a Paraíba');
});
