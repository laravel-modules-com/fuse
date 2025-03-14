<?php

declare(strict_types=1);

namespace Modules\Blog\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\Blog\Models\Post;

class PostsRss extends Component
{
    public function render(): View
    {
        $posts = Post::with('cats')->date()->order()->take(20)->get();

        return view('blog::livewire.rss', compact('posts'))->layout('layouts.raw');
    }
}
