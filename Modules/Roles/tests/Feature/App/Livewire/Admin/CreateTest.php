<?php

use Livewire\Livewire;
use Modules\Roles\Livewire\Admin\Create;
use Modules\Roles\Models\Role;

uses(Tests\TestCase::class);

beforeEach(function () {
    $this->authenticate();
});

test('can create role', function () {
    Livewire::test(Create::class)
        ->set('role', 'Editor')
        ->call('store')
        ->assertHasNoErrors(['role' => 'required']);

    $this->assertTrue(Role::where('name', 'editor')->exists());
});

test('cannot create role without role', function () {
    Livewire::test(Create::class)
        ->set('role', '')
        ->call('store')
        ->assertHasErrors(['role' => 'required']);
});

test('Can dispatch after role creation', function () {
    Livewire::test(Create::class)
        ->set('role', 'Editor')
        ->call('store')
        ->assertDispatched('refreshRoles')
        ->assertDispatched('close-modal');
});

test('on cancel dispatch browser event', function () {
    Livewire::test(Create::class)
        ->call('cancel')
        ->assertDispatched('close-modal');
});
