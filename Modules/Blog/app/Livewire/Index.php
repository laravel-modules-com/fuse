<?php

declare(strict_types=1);

namespace Modules\Blog\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\Blog\Models\Post;

class Index extends Component
{
    public function render(): View
    {
        $posts = Post::with('categories')->date()->order()->take(6)->get();

        return view('blog::livewire.index', compact('posts'))->layout('layouts.front');
    }
}
