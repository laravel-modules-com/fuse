<?php

use Livewire\Livewire;
use Modules\Admin\Livewire\Admin\NotificationsMenu;
use Modules\Admin\Models\Notification;

uses(Tests\TestCase::class);

test('can see notifications', function () {

    test()->authenticate();
    $user = auth()->user();

    Notification::factory()->create([
        'assigned_to_user_id' => $user->id,
        'assigned_from_user_id' => $user->id,
        'viewed' => 0,
        'viewed_at' => null,
    ]);

    Livewire::test(NotificationsMenu::class)
        ->assertSet('unseenCount', 1)
        ->call('open');

    Livewire::test(NotificationsMenu::class)
        ->call('open')
        ->assertSet('unseenCount', 0);
});
