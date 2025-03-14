<?php

namespace Modules\Blog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Blog\Models\Author;
use Modules\Blog\Models\Post;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'slug' => Str::slug(fake()->name()),
            'author_id' => Author::factory(),
            'description' => fake()->sentence(),
            'content' => fake()->sentence(),
            'display_at' => date('Y-m-d H:i:s'),
        ];
    }
}
