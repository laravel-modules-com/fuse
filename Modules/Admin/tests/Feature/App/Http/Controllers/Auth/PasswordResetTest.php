<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(Tests\TestCase::class);

test('reset password link screen can be rendered', function () {
get(route('password.request'))->assertOk();
    });

test('reset password link can be requested', function () {
    Notification::fake();

    $user = User::factory()->create();

    post(route('password.request'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class);
});

test('reset password screen can be rendered', function () {
    $this->withoutExceptionHandling();

    Notification::fake();

    $user = User::factory()->create();

    post(route('password.request'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
    get('/reset-password/'.$notification->token)->assertOk();

        return true;
        });
});
