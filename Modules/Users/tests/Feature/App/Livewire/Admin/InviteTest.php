<?php

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Modules\Roles\Models\Role;
use Modules\Users\Livewire\Admin\Invite;
use Modules\Users\Mail\SendInviteMail;

beforeEach(function () {
    $this->authenticate();
});

test('can invite user', function () {

    $name = fake()->name;
    $email = fake()->email;
    Role::create([
        'name' => 'editor',
        'label' => 'Editor',
    ]);

    Livewire::test(Invite::class)
        ->set('name', $name)
        ->set('email', $email)
        ->set('rolesSelected', ['editor'])
        ->assertSet('name', $name)
        ->assertSet('email', $email)
        ->assertSet('rolesSelected', ['editor'])
        ->call('store')
        ->assertOk();
});

test('creates a new user on invite', function () {

    $name = fake()->name;
    $email = fake()->email;
    Role::create([
        'name' => 'editor',
        'label' => 'Editor',
    ]);

    Livewire::test(Invite::class)
        ->set('name', $name)
        ->set('email', $email)
        ->set('rolesSelected', ['editor'])
        ->call('store');

    $this->assertDatabaseHas('users', [
        'name' => $name,
        'email' => $email,
        'is_active' => 0,
        'is_office_login_only' => 0,
        'invited_by' => auth()->id(),
    ]);

    $newUser = User::where('email', $email)->first();

    expect($newUser->invite_token)->not()->toBeNull()
        ->and($newUser->invited_by)->toBe(auth()->id())
        ->and($newUser->invited_at)->not()->toBeNull();
});

test('send invite email on invite', function () {

    Mail::fake();

    $name = fake()->name;
    $email = fake()->email;
    Role::create([
        'name' => 'editor',
        'label' => 'Editor',
    ]);

    Livewire::test(Invite::class)
        ->set('name', $name)
        ->set('email', $email)
        ->set('rolesSelected', ['editor'])
        ->call('store');

    Mail::assertQueued(SendInviteMail::class, function (SendInviteMail $mail) {
        return $mail->onQueue('notifications');
    });
});

test('name is required', function () {
    Livewire::test(Invite::class)
        ->set('name', '')
        ->call('store')
        ->assertHasErrors(['name']);
});

test('email is required', function () {
    Livewire::test(Invite::class)
        ->set('email', '')
        ->call('store')
        ->assertHasErrors(['email']);
});

test('roles are required', function () {
    Livewire::test(Invite::class)
        ->set('rolesSelected', [])
        ->call('store')
        ->assertHasErrors(['rolesSelected']);
});

test('close-modal is dispatched', function () {
    Livewire::test(Invite::class)
        ->call('cancel')
        ->assertOk()
        ->assertDispatched('close-modal');
});
