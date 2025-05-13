<?php

use Livewire\Livewire;
use Modules\Roles\Livewire\Admin\Create;
use Modules\Roles\Models\Role;

beforeEach(function () {
    $this->authenticate();
});

test('can create role', function () {
    Livewire::test(Create::class)
        ->set('label', 'Editor')
        ->call('store')
        ->assertHasNoErrors(['role' => 'required']);

    $this->assertTrue(Role::where('name', 'editor')->exists());
});

test('cannot create role without role', function () {
    Livewire::test(Create::class)
        ->set('label', '')
        ->call('store')
        ->assertHasErrors(['label' => 'required']);
});

test('Can dispatch after role creation', function () {
    Livewire::test(Create::class)
        ->set('label', 'Editor')
        ->call('store')
        ->assertDispatched('added');
});
