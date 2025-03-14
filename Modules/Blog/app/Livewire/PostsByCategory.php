<?php

declare(strict_types=1);

namespace Modules\Blog\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Modules\Blog\Models\Category as CategoryModel;
use Modules\Blog\Models\Post;

class PostsByCategory extends Component
{
    public $slug;

    public function mount($slug): void
    {
        $this->slug = $slug;
    }

    public function render(): View
    {
        $posts = Post::with('categories')->whereHas('categories', function ($query) {
            $query->where('slug', $this->slug);
        })->date()->order()->paginate();

        if ($posts->total() === 0) {
            abort(404);
        }

        $cat = CategoryModel::where('slug', $this->slug)->first();
        $pageTitle = "Posts in category: $cat->title";

        return view('blog::livewire.index', compact('posts', 'cat', 'pageTitle'))->layout('layouts.front');
    }
}
