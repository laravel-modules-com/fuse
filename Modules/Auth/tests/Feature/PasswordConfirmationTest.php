<?php

use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(Tests\TestCase::class);

beforeEach(function () {
    test()->authenticate();
});

test('confirm password screen can be rendered', function () {
    get(route('password.confirm'))
        ->assertOk();
});

test('password can be confirmed', function () {
    post(route('password.confirm'), [
        'password' => 'password',
    ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
    post(route('password.confirm'), [
        'password' => 'wrong-password',
    ])->assertSessionHasErrors();
});
