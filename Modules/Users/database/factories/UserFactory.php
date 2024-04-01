<?php

namespace Modules\Users\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'slug' => Str::slug(fake()->name()),
            'email' => fake()->email(),
            'password' => Hash::make('password'),
            'is_active' => 1,
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),
            'image' => null,
            'two_fa_active' => false,
            'two_fa_secret_key' => null,
            'is_office_login_only' => 0,
        ];
    }
}
