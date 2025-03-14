<?php

namespace Modules\Blog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\CategoryPost;
use Modules\Blog\Models\Post;

class CategoryPostFactory extends Factory
{
    protected $model = CategoryPost::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::factory()->create(),
            'post_id' => Post::factory()->create(),
        ];
    }
}
