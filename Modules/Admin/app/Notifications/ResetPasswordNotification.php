<?php

namespace Modules\Admin\Notifications;

use DateTimeInterface;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordNotification extends ResetPassword implements ShouldQueue
{
    public string $queue = 'notifications';

    public ?string $connection = null;

    public int|DateTimeInterface|null $delay = null;
}
