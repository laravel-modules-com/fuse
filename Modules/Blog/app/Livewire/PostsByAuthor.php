<?php

declare(strict_types=1);

namespace Modules\Blog\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\Blog\Models\Author;
use Modules\Blog\Models\Post;

class PostsByAuthor extends Component
{
    public $slug;

    public function mount($slug): void
    {
        $this->slug = $slug;
    }

    public function render(): View
    {
        $posts = Post::with('author')->whereHas('author', function ($query) {
            $query->where('slug', $this->slug);
        })->date()->order()->paginate();

        if ($posts->total() === 0) {
            abort(404);
        }

        $author = Author::where('slug', $this->slug)->first();
        $pageTitle = "Posts by author: $author->name";

        return view('blog::livewire.index', compact('posts', 'author', 'pageTitle'))->layout('layouts.front');
    }
}
