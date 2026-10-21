<?php

use App\Enums\UserRole;
use App\Filament\Auth\Register;
use App\Models\User;
use Livewire\Livewire;

test('the member register page renders the split brand layout', function () {
    $this->get('/membro/register')
        ->assertOk()
        ->assertSee('fi-login-brand-panel', false)
        ->assertSee('A comunidade PHP que conecta a Paraíba');
});

test('the admin panel has no registration route', function () {
    $this->get('/admin/register')->assertNotFound();
});

test('the member login page links to the register page', function () {
    $this->get('/membro/login')
        ->assertOk()
        ->assertSee('membro/register', false);
});

test('a visitor can register as a member and is logged in with the member role', function () {
    Livewire::test(Register::class)
        ->fillForm([
            'name' => 'Nova Desenvolvedora',
            'email' => 'nova@example.com',
            'cargo' => 'Desenvolvedora Back-End',
            'password' => 'password-forte-123',
            'passwordConfirmation' => 'password-forte-123',
        ])
        ->call('register')
        ->assertHasNoFormErrors();

    $user = User::where('email', 'nova@example.com')->first();

    expect($user)->not->toBeNull()
        ->and($user->role)->toBe(UserRole::Member)
        ->and($user->slug)->not->toBeNull();

    $this->assertAuthenticatedAs($user, 'web');
});
