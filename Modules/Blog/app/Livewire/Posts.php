<?php

declare(strict_types=1);

namespace Modules\Blog\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\Blog\Models\Post;

class Posts extends Component
{
    public function render(): View
    {
        $posts = Post::with('categories')
            ->date()
            ->order()
            ->paginate();

        return view('blog::livewire.posts', compact('posts'))->layout('layouts.front');
    }
}
