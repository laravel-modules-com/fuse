<?php

use Livewire\Livewire;
use Modules\Blog\Livewire\Admin\Posts\AddPost;
use Modules\Blog\Livewire\Admin\Posts\EditPost;
use Modules\Blog\Livewire\Admin\Posts\Posts;
use Modules\Blog\Models\Author;
use Modules\Blog\Models\Post;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function PHPUnit\Framework\assertTrue;

uses(Tests\TestCase::class);

beforeEach(function () {
    test()->user = test()->authenticate();
});

test('can see posts', function () {
get(route('admin.blog.index'))->assertOk();
    });

test('cannot see posts without admin permission', function () {
    test()->authenticate('user');

    get(route('admin.blog.index'))->assertForbidden();
});

test('can see create post button', function () {
get(route('admin.blog.index'))
->assertOk()
->assertSee('Create Post');
    });

test('can see manage categories button', function () {
get(route('admin.blog.index'))
->assertOk()
->assertSee('Manage Categories');
    });

test('can search posts', function () {
    Livewire::test(Posts::class)
        ->set('title', 'artisan')
        ->assertSet('title', 'artisan');
});

test('can set property', function () {
    Livewire::test(Posts::class)
        ->set('sortField', 'title')
        ->assertSet('sortField', 'title');
});

test('can sort posts', function () {
    Livewire::test(Posts::class)
        ->call('sortBy', 'title')
        ->assertSet('sortField', 'title')
        ->call('posts')
        ->assertOk();
});

test('can create post', function () {
    $author = Author::factory()->create();

    Livewire::test(AddPost::class)
        ->set('title', 'Top 10 ways to test')
        ->set('description', 'intro text')
        ->set('content', 'main text')
        ->set('displayAt', date('d-m-Y H:i'))
        ->set('authorId', $author->id)
        ->call('store')
        ->assertHasNoErrors();

    assertTrue(Post::where('title', 'Top 10 ways to test')->exists());
});

test('cannot create post without name', function () {
    Livewire::test(AddPost::class)
        ->set('title', '')
        ->call('store')
        ->assertHasErrors(['title' => 'required']);
});

test('cannot create post without display at date', function () {
    Livewire::test(AddPost::class)
        ->set('displayAt', '')
        ->call('store')
        ->assertHasErrors(['displayAt' => 'required']);
});

test('cannot create post with invalid display at date', function () {
    Livewire::test(AddPost::class)
        ->set('displayAt', date('Y-m-d'))
        ->call('store')
        ->assertHasErrors(['displayAt' => 'date_format']);
});

test('cannot create post without description', function () {
    Livewire::test(AddPost::class)
        ->set('description', '')
        ->call('store')
        ->assertHasErrors(['description' => 'required']);
});

test('cannot create post without content', function () {
    Livewire::test(AddPost::class)
        ->set('content', '')
        ->call('store')
        ->assertHasErrors(['content' => 'required']);
});

test('is redirected after post creation', function () {
    $author = Author::factory()->create();

    Livewire::test(AddPost::class)
        ->set('title', 'Top 10 ways to test')
        ->set('description', 'intro text')
        ->set('content', 'main text')
        ->set('displayAt', date('d-m-Y H:i'))
        ->set('authorId', $author->id)
        ->call('store')
        ->assertRedirect(route('admin.blog.index'));
});

test('can update post', function () {
    $post = Post::factory()->create();
    Livewire::test(EditPost::class, ['post' => $post])
        ->set('title', 'Misc')
        ->call('update')
        ->assertSessionHasNoErrors();

    assertDatabaseHas(Post::class, ['title' => 'Misc']);
});
