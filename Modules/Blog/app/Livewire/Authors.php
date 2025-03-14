<?php

declare(strict_types=1);

namespace Modules\Blog\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Modules\Blog\Models\Post;

class Authors extends Component
{
    public function render(): View
    {
        $authors = Post::select('author_id')
            ->date()
            ->groupBy('author_id')
            ->get();

        return view('blog::livewire.authors', compact('authors'))->layout('layouts.front');
    }
}
