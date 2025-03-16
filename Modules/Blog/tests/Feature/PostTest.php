<?php

use Modules\Blog\Models\Author;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\CategoryPost;
use Modules\Blog\Models\Post;

use function Pest\Laravel\get;

uses(Tests\TestCase::class);

test('can see posts', function () {
    get(route('blog.index'))
        ->assertOk();
});

test('can see single post', function () {
    $post = Post::factory()->create();
    get(route('blog.show', $post->slug))
        ->assertOk();
});

test('can see categories', function () {
    get(route('blog.categories.index'))
        ->assertOk();
});

test('can see single category', function () {
    $category = Category::factory()->create();
    $post = Post::factory()->create();

    CategoryPost::create([
        'post_id' => $post->id,
        'category_id' => $category->id,
    ]);

    get(route('blog.categories.show', $category->slug))
        ->assertOk();
});

test('can see authors', function () {
    get(route('blog.authors.index'))
        ->assertOk();
});

test('can see single author', function () {
    $author = Author::factory()->create();

    Post::factory()->create([
        'author_id' => $author->id,
    ]);

    get(route('blog.authors.show', $author->slug))
        ->assertOk();
});

test('can see rss', function () {
    get(route('blog.rss'))
        ->assertOk();
});
