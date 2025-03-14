<?php

use Modules\Blog\Http\Controllers\XmlController;
use Modules\Blog\Livewire\Admin\Authors\Authors as AdminAuthors;
use Modules\Blog\Livewire\Admin\Categories\Categories as AdminCategories;
use Modules\Blog\Livewire\Admin\Posts\AddPost;
use Modules\Blog\Livewire\Admin\Posts\EditPost;
use Modules\Blog\Livewire\Admin\Posts\Posts;
use Modules\Blog\Livewire\Archives;
use Modules\Blog\Livewire\Authors;
use Modules\Blog\Livewire\Categories;
use Modules\Blog\Livewire\Index;
use Modules\Blog\Livewire\Post;
use Modules\Blog\Livewire\Posts as Articles;
use Modules\Blog\Livewire\PostsByAuthor;
use Modules\Blog\Livewire\PostsByCategory;

Route::prefix(config('fuse.prefix'))->middleware(['auth', 'verified', 'activeUser', 'ipCheckMiddleware'])->group(function () {
    Route::get('blog', Posts::class)->name('admin.blog.index');
    Route::get('blog/create', AddPost::class)->name('admin.blog.posts.create');
    Route::get('blog/edit/{post}', EditPost::class)->name('admin.blog.posts.edit');
    Route::get('blog/categories', AdminCategories::class)->name('admin.blog.categories.index');
    Route::get('blog/authors', AdminAuthors::class)->name('admin.blog.authors.index');
});

Route::prefix('blog')->group(function () {
    Route::get('/', Index::class)->name('blog.index');
    Route::get('posts', Articles::class)->name('blog.posts.index');
    Route::get('categories', Categories::class)->name('blog.categories.index');
    Route::get('categories/{slug:slug}', PostsByCategory::class)->name('blog.categories.show');
    Route::get('authors', Authors::class)->name('blog.authors.index');
    Route::get('author/{slug:slug}', PostsByAuthor::class)->name('blog.authors.show');
    Route::get('rss', [XmlController::class, 'rss'])->name('blog.rss');
    Route::get('archives', Archives::class)->name('blog.archives.index');
    Route::get('{slug:slug}', Post::class)->name('blog.show');
});
