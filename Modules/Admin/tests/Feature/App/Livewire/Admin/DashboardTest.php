<?php

use function Pest\Laravel\get;

uses(Tests\TestCase::class);

test('can see dashboard as admin regardless of permission', function () {
    test()->authenticate();

    get(route('dashboard'))
        ->assertOk();
});

test('can see dashboard with a none admin role as long as has permission', function () {
    test()->authenticate('editor', 'view_dashboard');

    get(route('dashboard'))
        ->assertOk();
});

test('cannot see dashboard without permission', function () {
    test()->authenticate('editor');

    get(route('dashboard'))
        ->assertForbidden();
});
