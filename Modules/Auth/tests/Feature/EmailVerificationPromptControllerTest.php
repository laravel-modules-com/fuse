<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(Tests\TestCase::class);

test('email verification screen can be rendered', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    actingAs($user)
        ->get(route('verification.notice'))
        ->assertOk();
});

test('verify-email redirects', function () {
    test()->authenticate();

    get(route('verification.notice'))
        ->assertRedirect(route('dashboard'));
});
