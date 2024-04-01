<?php

namespace Modules\Admin\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Models\Notification;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        $user1 = User::factory()->make();
        $user2 = User::factory()->make();

        return [
            'title' => $this->faker->name(),
            'assigned_from_user_id' => $user1->id,
            'assigned_to_user_id' => $user2->id,
        ];
    }
}
