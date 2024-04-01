<?php

use Modules\Users\Livewire\Admin\Edit\AdminSettings;

uses(Tests\TestCase::class);

test('can see edit user page', function () {
    $this->authenticate();
    $this
        ->get(route('admin.users.edit', auth()->user()))
        ->assertSeeLivewire(AdminSettings::class);
});
