<?php

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Modules\Admin\Notifications\ResetPasswordNotification;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

test('reset password link screen can be rendered', function () {
    get(route('password.request'))->assertOk();
});

test('reset password link can be requested', function () {
    Notification::fake();

    $user = User::factory()->create();

    post(route('password.request'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPasswordNotification::class);
});

test('reset password screen can be rendered', function () {
    Notification::fake();

    $user = User::factory()->create();

    post(route('password.request'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPasswordNotification::class, function (ResetPasswordNotification $notification) {
        get('/reset-password/'.$notification->token)->assertOk();

        return true;
    });
});
