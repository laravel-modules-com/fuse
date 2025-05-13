<?php

namespace Modules\Admin\Notifications;

use DateTimeInterface;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyEmailNotification extends VerifyEmail implements ShouldQueue
{
    public string $queue = 'notifications';

    public ?string $connection = null;

    public int|DateTimeInterface|null $delay = null;
}
