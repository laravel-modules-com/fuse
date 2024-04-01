<?php

use App\Models\User;

uses(Tests\TestCase::class);

beforeEach(function () {
    $this->authenticate();
});

test('can see profile', function () {
    $this
        ->get(route('admin.users.show', User::factory()->create()))
        ->assertOk();
});
