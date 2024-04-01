<?php

use Livewire\Livewire;
use Modules\Roles\Livewire\Admin\Edit;
use Modules\Roles\Models\Permission;
use Modules\Roles\Models\Role;

uses(Tests\TestCase::class);

beforeEach(function () {
    $this->authenticate();
});

test('can see edit role page', function () {
    $role = Role::where('name', 'admin')->first();
    $this->get(route('admin.settings.roles.edit', $role))->assertOk();
});

test('cannot update role without label', function () {
    $role = Role::where('name', 'admin')->first();

    Livewire::test(Edit::class, ['role' => $role])
        ->set('label', '')
        ->call('update')
        ->assertSee('Role is required')
        ->assertHasErrors('label');
});

test('can update role', function () {
    $role = Role::where('name', 'admin')->first();

    Permission::create([
        'name' => 'view_dashboard',
        'label' => 'View Dashboard',
        'module' => 'App',
    ]);

    $permissions = Permission::get()->pluck('name')->toArray();

    $role->syncPermissions($permissions);

    Livewire::test(Edit::class, ['role' => $role])
        ->set('label', 'Test')
        ->call('update')
        ->assertHasNoErrors()
        ->assertSet('permissions', $permissions)
        ->assertRedirect(route('admin.settings.roles.index'));

    expect($role->fresh()->permissions)->toHaveCount(1);
});
